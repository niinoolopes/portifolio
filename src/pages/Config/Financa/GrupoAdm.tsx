import { useCallback, useEffect, useState } from "react"
import { FaSave } from "react-icons/fa"
import Select from "../../../components/form/Select"
import Breadcrumb from "../../../components-layout/Breadcrumb"
import ContentSection from "../../../components-layout/ContentSection"
import { useContextFinanca } from "../../../context/financa"
import { useContextGlobal } from "../../../context/global"
import useForm from "../../../hooks/useForm"
import useNavigate from "../../../hooks/useNavigate"
import GrupoModel from "../../../models/config/financa/GrupoModel"
import { IFinanca, IFNGP } from "../../../types/financa"
import OptionsCarteira from '../../../components/form/financa/OptionsCarteira'
import OptionsTipo from "../../../components/form/financa/OptionsTipo"
import Input from "../../../components/form/Input"
import OptionsStatus from "../../../components/form/OptionsStatus"
import OptionsFechamento from "../../../components/form/financa/OptionsFechamento"
import { formFinancaGrupo } from "../../../contextData/financa"
import LoadingPage from "../../../components/loading/LoadingPage"

export default function GrupoId() {
  const { urlParams, urlNavigate } = useNavigate()
  const { setDataFinanca } = useContextGlobal()
  const { getCarteiraPanel, getCarteira } = useContextFinanca()
  const { formRegister, formSubmit, formErrors, InputTextRequired, InputSelectRequired } = useForm()
  const [dataPage, serDataPage] = useState<IFNGP>({
    ...formFinancaGrupo,
    fnct_id: Number(getCarteiraPanel.fnct_id)
  })
  const { isFetching, grupoGet, grupoStore, grupoUpdate } = GrupoModel()
  const [loadPage, setLoadPage] = useState<boolean>(true)

  const handleSubmit = async (fields: IFNGP) => {
    let body: IFNGP = { ...dataPage, ...fields }

    const method: any = body.fngp_id === 'new'
      ? grupoStore
      : grupoUpdate

    const responseMethod = await method({
      body,
      fngp_id: body.fngp_id
    })

    if (responseMethod.status) {
      const responseGet = await grupoGet()

      if (responseGet.status) {

        setDataFinanca((obj: IFinanca) => {
          return {
            ...obj,
            grupo: responseGet.items
          }
        })
      }

      urlNavigate(`/configuracao/financa/grupo`)
    }
  }

  const getId = useCallback(async () => {
    const { status, item } = await grupoGet({ fngp_id: urlParams.id })

    if (status) {
      serDataPage(item);
    }

    setLoadPage(false)

    /* eslint-disable-next-line react-hooks/exhaustive-deps */
  }, [urlParams])

  useEffect(() => {
    if (urlParams.id) {

      getId()

    } else {

      setLoadPage(false)
    }
    /* eslint-disable-next-line react-hooks/exhaustive-deps */
  }, [])

  return (
    <>
      <LoadingPage
        isFetch={isFetching}
      />

      <Breadcrumb
        items={[
          { label: 'Home', url: '/dashboard' },
          { label: 'Configuração', url: '/configuracao' },
          { label: 'Finança grupo', url: '/configuracao/financa/grupo' },
          { label: `${dataPage.fngp_id === 'new' ? 'Adicionar' : 'Editar'}` },
        ]}
      />

      <ContentSection
        isFetching={loadPage}
        title="Grupo"
        btns={(
          <>
            <button type="submit" className="btn btn-sm" form="formGrupo"><FaSave /></button>
          </>
        )}
      >
        <form id="formGrupo" onSubmit={formSubmit(handleSubmit)}>
          <div className="row gx-2 gy-3">

            <div className="col-12 col-md-4 col-lg-3">
              <Select
                label="Carteira"
                disabled={isFetching}
                name="fnct_id"
                register={formRegister}
                options={InputSelectRequired}
                error={formErrors.fnct_id}
                defaultValue={String(dataPage?.fnct_id)}
              >
                <OptionsCarteira items={getCarteira} />
              </Select>
            </div>

            <div className="col-12 col-md-4 col-lg-3">
              <Select
                label="Tipo"
                disabled={isFetching}
                name="fntp_id"
                register={formRegister}
                options={InputSelectRequired}
                error={formErrors.fntp_id}
                defaultValue={String(dataPage?.fntp_id)}
              >
                <OptionsTipo />
              </Select>
            </div>

            <div className="col-12 col-md-4 col-lg-6 d-none d-lg-block"></div>

            <div className="col-12 col-md-4 col-lg-3">
              <Input
                label="Descrição"
                placeholder="Digite uma descrição"
                type="text"
                disabled={isFetching}
                name="fngp_description"
                register={formRegister}
                options={InputTextRequired}
                error={formErrors.fngp_description}
                defaultValue={dataPage.fngp_description}
              />
            </div>

            <div className="col-6 col-md-4 col-lg-3">
              <Select
                label="Status"
                disabled={isFetching}
                name="fngp_enable"
                register={formRegister}
                options={InputSelectRequired}
                error={formErrors.fngp_enable}
                defaultValue={String(dataPage?.fngp_enable)}
              >
                <OptionsStatus />
              </Select>
            </div>

            <div className="col-6 col-md-4 col-lg-3">
              <Select
                label="Fechamento"
                disabled={isFetching}
                name="fngp_fechamento"
                register={formRegister}
                options={InputSelectRequired}
                error={formErrors.fngp_fechamento}
                defaultValue={String(dataPage?.fngp_fechamento)}
              >
                <OptionsFechamento />
              </Select>
            </div>

          </div>
        </form>
      </ContentSection>
    </>
  )
}
