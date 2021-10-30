import { useCallback, useEffect, useRef, useState } from "react"
import { FaSave } from "react-icons/fa"
import OptionsCarteira from "../../../components/form/financa/OptionsCarteira"
import OptionsFechamento from "../../../components/form/financa/OptionsFechamento"
import OptionsGrupo from "../../../components/form/financa/OptionsGrupo"
import OptionsTipo from "../../../components/form/financa/OptionsTipo"
import Input from "../../../components/form/Input"
import OptionsStatus from "../../../components/form/OptionsStatus"
import Select from "../../../components/form/Select"
import Textarea from "../../../components/form/Textarea"
import Breadcrumb from "../../../components-layout/Breadcrumb"
import ContentSection from "../../../components-layout/ContentSection"
import LoadingPage from "../../../components/loading/LoadingPage"
import { useContextFinanca } from "../../../context/financa"
import { useContextGlobal } from "../../../context/global"
import { formFinancaCategoria } from "../../../contextData/financa"
import useForm from "../../../hooks/useForm"
import useNavigate from "../../../hooks/useNavigate"
import CategoriaModel from "../../../models/config/financa/CategoriaModel"
import { IFinanca, IFNCG } from "../../../types/financa"

export default function CategoriaAdm() {
  const isMounted = useRef(true)
  const { urlParams, urlNavigate } = useNavigate()
  const { setDataFinanca } = useContextGlobal()
  const { getCarteiraPanel, getCarteira, setGrupo, getGrupo } = useContextFinanca()
  const { formRegister, formSubmit, formErrors, InputTextRequired, InputSelectRequired } = useForm()
  const [dataPage, serDataPage] = useState<IFNCG>({
    ...formFinancaCategoria,
    fnct_id: Number(getCarteiraPanel.fnct_id)
  })
  const { isFetching, categoriaGet, categoriaStore, categoriaUpdate } = CategoriaModel()
  const [loadPage, setLoadPage] = useState<boolean>(true)

  const handleSubmit = async (fields: IFNCG) => {
    let body: IFNCG = { ...dataPage, ...fields }

    const method: any = body.fncg_id === 'new'
      ? categoriaStore
      : categoriaUpdate

    const responseMethod = await method({
      body,
      fncg_id: body.fncg_id
    })

    if (responseMethod.status) {
      const responseGet = await categoriaGet()

      await setDataFinanca((obj: IFinanca) => {
        return {
          ...obj,
          categoria: responseGet.items
        }
      })

      urlNavigate(`/configuracao/financa/categoria`)
    }
  }

  const getId = useCallback(async () => {
    setLoadPage(true)

    const { status, item } = await categoriaGet({ fncg_id: urlParams.id })

    if (status) {
      setGrupo({
        fnct_id: item.fnct_id,
        fntp_id: Number(item.fngp?.fntp?.fntp_id)
      })
      serDataPage({
        ...item,
        fntp_id: Number(item.fngp?.fntp?.fntp_id)
      });
    }

    setLoadPage(false)
    /* eslint-disable-next-line react-hooks/exhaustive-deps */
  }, [urlParams])


  useEffect(() => {
    if (isMounted.current) {
      if (urlParams.id) {

        getId()

      } else {

        setGrupo({
          fnct_id: dataPage.fnct_id,
          fntp_id: 1
        })

        setLoadPage(false)
      }
    }

    return () => { isMounted.current = false };
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
          { label: 'Finança categoria', url: '/configuracao/financa/categoria' },
          { label: `${dataPage.fncg_id === 'new' ? 'Adicionar' : 'Editar'}` },
        ]}
      />

      <ContentSection
        isFetching={loadPage}
        title="Categoria"
        btns={(
          <>
            <button type="submit" className="btn btn-sm" form="formCategoria"><FaSave /></button>
          </>
        )}
      >
        <form id="formCategoria" onSubmit={formSubmit(handleSubmit)}>
          <div className="row gx-2 gy-3">

            <div className="col-6 col-md-4 col-lg-3">
              <Select
                label="Carteira"
                disabled={isFetching}
                name="fnct_id"
                register={formRegister}
                options={InputSelectRequired}
                error={formErrors.fnct_id}
                defaultValue={String(dataPage.fnct_id)}
                onChange={({ target }: any) => setGrupo({ fnct_id: Number(target.value), fntp_id: Number(dataPage.fntp_id) })}
              >
                <OptionsCarteira items={getCarteira} />
              </Select>
            </div>

            <div className="col-6 col-md-4 col-lg-3">
              <Select
                label="Tipo"
                disabled={isFetching}
                name="fntp_id"
                register={formRegister}
                options={InputSelectRequired}
                error={formErrors.fntp_id}
                defaultValue={String(dataPage.fntp_id)}
                onChange={({ target }: any) => setGrupo({ fntp_id: Number(target.value), fnct_id: Number(dataPage.fnct_id) })}
              >
                <OptionsTipo />
              </Select>
            </div>

            <div className="col-6 col-md-4 col-lg-3">
              <Select
                label="Grupo"
                disabled={isFetching}
                name="fngp_id"
                register={formRegister}
                options={InputSelectRequired}
                error={formErrors.fngp_id}
                defaultValue={String(dataPage.fngp_id)}
              >
                <OptionsGrupo items={getGrupo} />
              </Select>
            </div>

            <div className="col-12 col-md-4 col-lg-3 d-none d-lg-block"></div>

            <div className="col-12 col-md-4 col-lg-3">
              <Input
                label="Descrição"
                placeholder="Digite uma descrição"
                type="text"
                disabled={isFetching}
                name="fncg_description"
                register={formRegister}
                options={InputTextRequired}
                error={formErrors.fncg_description}
                defaultValue={String(dataPage.fncg_description)}
              />
            </div>

            <div className="col-6 col-md-4 col-lg-3">
              <Select
                label="Status"
                disabled={isFetching}
                name="fncg_enable"
                register={formRegister}
                options={InputSelectRequired}
                error={formErrors.fncg_enable}
                defaultValue={String(dataPage.fncg_enable)}
              >
                <OptionsStatus />
              </Select>
            </div>

            <div className="col-6 col-md-4 col-lg-3">
              <Select
                label="Fechamento"
                disabled={isFetching}
                name="fncg_fechamento"
                register={formRegister}
                options={InputSelectRequired}
                error={formErrors.fncg_fechamento}
                defaultValue={String(dataPage.fncg_fechamento)}
              >
                <OptionsFechamento />
              </Select>
            </div>

            <div className="col-12 col-md-6">
              <Textarea
                label="Obs"
                disabled={isFetching}
                maxLength="200"
                name="fncg_obs"
                register={formRegister}
                options={InputTextRequired}
                error={formErrors.fncg_obs}
                defaultValue={String(dataPage.fncg_obs)}
              />
            </div>

          </div>
        </form>
      </ContentSection>
    </>
  )
}
