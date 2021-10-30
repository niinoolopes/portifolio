import { useCallback, useEffect, useRef, useState } from "react"
import { FaSave, FaTrashAlt } from "react-icons/fa"
import OptionsCarteira from "../../components/form/financa/OptionsCarteira"
import OptionsCategoria from "../../components/form/financa/OptionsCategoria"
import OptionsGrupo from "../../components/form/financa/OptionsGrupo"
import OptionsSituacao from "../../components/form/financa/OptionsSituacao"
import OptionsTipo from "../../components/form/financa/OptionsTipo"
import Input from "../../components/form/Input"
import OptionsStatus from "../../components/form/OptionsStatus"
import Select from "../../components/form/Select"
import Textarea from "../../components/form/Textarea"
import Breadcrumb from "../../components-layout/Breadcrumb"
import ContentSection from "../../components-layout/ContentSection"
import LoadingPage from "../../components/loading/LoadingPage"
import Navbar from "../../components/navabar/Navbar"
import { useContextFinanca } from "../../context/financa"
import { useContextGlobal } from "../../context/global"
import { formFinancaItem } from "../../contextData/financa"
import useForm from "../../hooks/useForm"
import useNavigate from "../../hooks/useNavigate"
import ItemModel from "../../models/financa/ItemModel"
import consolidadoItemModel from "../../models/financa/ConsolidadoItemModel"
import { IFNCG, IFNIT } from "../../types/financa"

type IhandleInput = {
  key: string
  value: string | number
}

export default function Item() {
  const isMounted = useRef(true)
  const { dataFinanca } = useContextGlobal()
  const { getCarteiraPanel, getCarteira, getGrupo, setGrupo, getCategoria, setCategoria } = useContextFinanca()
  const { urlParams, urlNavigate, urlSearch } = useNavigate()
  const { formRegister, formSubmit, formErrors, InputTextRequired, InputSelectRequired, formGetValues, formSetValue } = useForm()
  const { isFetch, itemGet, itemStore, itemUpdate, itemDelete } = ItemModel()
  const { consolidar } = consolidadoItemModel()
  const [dataPage, setDataPage] = useState<IFNIT>({
    ...formFinancaItem,
    fnct_id: Number(getCarteiraPanel.fnct_id)
  })
  const [loadPage, setLoadPage] = useState<boolean>(true)

  const handleAfterSubmit = () => {
    let fromList: any, fromItem: any, to: any, fntp_id: any, fngp_id: any, fncg_id: any

    to = urlSearch('from') || ''
    fntp_id = urlSearch('fntp_id') || false
    fngp_id = urlSearch('fngp_id') || false
    fncg_id = urlSearch('fncg_id') || false

    fromList = [
      { label: "extrato", value: '/financa/extrato' },
      { label: "historico", value: '/financa/historico' },
      { label: "grupo-mes", value: '/financa/grupo-mes' },
      { label: "grupo-ano", value: '/financa/grupo-ano' },
      { label: "analise", value: `/financa/analise/grupo-categoria` },
    ]

    fromItem = fromList.find((el: { label: string }) => el.label === to)

    if (!fromItem) {
      console.warn(`Não foi definico uma 'options' com valor de '${to}'`)
      return
    }

    fromItem.value += '?from=item'
    fromItem.value += fntp_id ? `&fntp_id=${fntp_id}` : '';
    fromItem.value += fngp_id ? `&fngp_id=${fngp_id}` : '';
    fromItem.value += fncg_id ? `&fncg_id=${fncg_id}` : '';

    urlNavigate(fromItem.value)
  }

  const handleSubmit = async (fields: IFNIT) => {

    let body: IFNIT = { ...dataPage, ...fields }

    body.fnit_enable = Number(body.fnit_enable)

    const method: any = body.fnit_id === 'new'
      ? itemStore
      : itemUpdate

    const { data } = await method({
      body,
      fnit_id: body.fnit_id,
      fnct_id: body.fnct_id,
    })

    await consolidar({
      fnct_id: body.fnct_id,
      periodo: body.fnit_date
    })

    setDataPage({
      ...formFinancaItem,
      fnit_value: 0,
      fnit_obs: "",
      fnit_enable: 1,
      fngp_id: 0,
      fncg_id: 0,
      fntp_id: 2,
      fnis_id: 1,
      fnct_id: Number(getCarteiraPanel.fnct_id)
    })

    if (data) {
      handleAfterSubmit()
    }
  }

  const handleInputCategoria = (fncg_id: number) => {

    if (fncg_id) {
      const arr = dataFinanca.categoria

      const fnit_obsForm = formGetValues('fnit_obs')

      const obsInFormNotEmpty = !fnit_obsForm

      const obsInFormExistInCartegorias: boolean = !!arr.find((el: IFNCG) => {
        const obs1 = String(el.fncg_obs).toLocaleLowerCase()
        const obs2 = String(fnit_obsForm).toLocaleLowerCase()
        return obs1 === obs2
      })


      if (obsInFormExistInCartegorias || obsInFormNotEmpty) {
        const findCarteiraSelected: IFNCG = arr.find((el: IFNCG) => Number(el.fncg_id) === fncg_id)
        const newObs = findCarteiraSelected.fncg_obs || ''
        formSetValue('fnit_obs', newObs)
        handleInput({ key: 'fnit_obs', value: newObs })
      }
    }
  }

  const handleInput = ({ key, value }: IhandleInput) => {
    setDataPage(obj => {
      return {
        ...obj,
        [key]: value
      }
    })
  }

  const remove = async () => {
    const { status } = await itemDelete({
      fnct_id: Number(dataPage.fnct_id),
      fnit_id: Number(dataPage.fnit_id)
    })

    await consolidar({
      fnct_id: dataPage.fnct_id,
      periodo: dataPage.fnit_date
    })

    if (status === 201) {
      handleAfterSubmit()
    }
  }

  const getId = useCallback(async () => {

    const { item } = await itemGet({
      fnct_id: Number(getCarteiraPanel.fnct_id),
      fnit_id: Number(urlParams.id)
    })

    await setGrupo({ fntp_id: Number(item.fntp_id), fnct_id: Number(item.fnct_id) })
    await setCategoria({ fngp_id: Number(item.fngp_id) })

    await setDataPage(item);

    setLoadPage(false)
    /* eslint-disable-next-line react-hooks/exhaustive-deps */
  }, [urlParams])

  useEffect(() => {
    if (isMounted.current) {
      if (urlParams.id) {

        getId()

      } else {

        setGrupo({ fntp_id: Number(dataPage.fntp_id), fnct_id: Number(dataPage.fnct_id) })

        setLoadPage(false)
      }
    }

    return () => { isMounted.current = false };
    /* eslint-disable-next-line react-hooks/exhaustive-deps */
  }, [dataFinanca, urlParams])

  return (
    <>
      <LoadingPage
        isFetch={isFetch}
      />

      <Breadcrumb
        items={[
          { label: 'Home', url: '/dashboard' },
          { label: 'Finança', url: '/financa' },
          { label: 'Item' },
        ]}
      />

      <Navbar active="Item" links="financa" />

      <ContentSection
        isFetching={loadPage}
        btns={(
          <>
            {(dataPage.fnit_id !== 'new') &&
              <button type="button" className="btn btn-sm"
                onClick={remove}
              ><FaTrashAlt /></button>
            }
            <button type="submit" className="btn btn-sm" form="formItem"><FaSave /></button>
          </>
        )}
      >
        <form id="formItem" onSubmit={formSubmit(handleSubmit)}>
          <div className="row gx-2 gy-3">

            <div className="col-6 col-lg-3 col-xl-2">
              <Select
                label="Carteira"
                disabled={isFetch}
                name="fnct_id"
                register={formRegister}
                options={InputSelectRequired}
                error={formErrors.fnct_id}
                defaultValue={String(dataPage?.fnct_id)}
                onChange={({ target }: any) => {
                  setGrupo({ fnct_id: Number(target.value), fntp_id: Number(dataPage.fntp_id) })
                  setCategoria({ fnct_id: Number(target.value) })
                  handleInput({
                    key: 'fnct_id',
                    value: Number(target.value),
                  })

                }}
              >
                <OptionsCarteira items={getCarteira} />
              </Select>
            </div>

            <div className="col-6 col-lg-3 col-xl-2">
              <Select
                label="Tipo"
                disabled={isFetch}
                name="fntp_id"
                register={formRegister}
                options={InputSelectRequired}
                error={formErrors.fntp_id}
                value={String(dataPage.fntp_id)}
                onChange={({ target }: any) => {
                  setGrupo({ fntp_id: Number(target.value), fnct_id: Number(dataPage.fnct_id) })
                  handleInput({
                    key: 'fntp_id',
                    value: Number(target.value),
                  })
                }}
              >
                <OptionsTipo />
              </Select>
            </div>

            <div className="col-6 col-lg-3 col-xl-2">
              <Select
                label="Grupo"
                disabled={isFetch || !dataPage.fntp_id}
                name="fngp_id"
                register={formRegister}
                options={InputSelectRequired}
                error={formErrors.fngp_id}
                value={String(dataPage.fngp_id)}
                onChange={({ target }: any) => {
                  setCategoria({ fngp_id: Number(target.value) })
                  handleInput({
                    key: 'fngp_id',
                    value: Number(target.value),
                  })
                }}
              >
                <OptionsGrupo items={getGrupo} />
              </Select>
            </div>

            <div className="col-6 col-lg-3 col-xl-2">
              <Select
                label="Categoria"
                disabled={isFetch || !dataPage.fngp_id}
                name="fncg_id"
                register={formRegister}
                options={InputSelectRequired}
                error={formErrors.fncg_id}
                value={String(dataPage.fncg_id)}
                onChange={({ target }: any) => {
                  handleInputCategoria(Number(target.value))
                  handleInput({
                    key: 'fncg_id',
                    value: Number(target.value),
                  })
                }}
              >
                <OptionsCategoria items={getCategoria} />
              </Select>
            </div>

            <div className="col-6 col-lg-3 col-xl-2">
              <Select
                label="Situação"
                disabled={isFetch || !dataPage.fncg_id}
                name="fnis_id"
                register={formRegister}
                options={InputSelectRequired}
                error={formErrors.fnis_id}
                value={String(dataPage.fnis_id)}
                onChange={({ target }: any) => {
                  handleInput({
                    key: 'fnis_id',
                    value: Number(target.value),
                  })
                }}
              >
                <OptionsSituacao />
              </Select>
            </div>

            <div className="col-6 col-lg-3 col-xl-2">
              <Input
                label="Valor"
                type="number"
                step="0.01"
                disabled={isFetch || !dataPage.fnis_id}
                name="fnit_value"
                register={formRegister}
                options={InputTextRequired}
                error={formErrors.fnit_value}
                value={dataPage.fnit_value}
                onChange={({ target }: any) => {
                  handleInput({
                    key: 'fnit_value',
                    value: target.value,
                  })
                }}
              />
            </div>

            <div className="col-6 col-lg-3 col-xl-2">
              <Select
                label="Status"
                disabled={isFetch || !dataPage.fnit_value}
                name="fnit_enable"
                register={formRegister}
                options={InputSelectRequired}
                error={formErrors.fnit_enable}
                value={String(dataPage.fnit_enable)}
                onChange={({ target }: any) => {
                  handleInput({
                    key: 'fnit_enable',
                    value: target.value,
                  })
                }}
              >
                <OptionsStatus />
              </Select>
            </div>

            <div className="col-6 col-lg-3 col-xl-2">
              <Input
                label="Data"
                type="date"
                disabled={isFetch || !dataPage.fnit_enable}
                name="fnit_date"
                register={formRegister}
                options={InputTextRequired}
                error={formErrors.fnit_date}
                value={String(dataPage.fnit_date)}
                onChange={({ target }: any) => {
                  handleInput({
                    key: 'fnit_date',
                    value: target.value,
                  })
                }}
              />
            </div>

            <div className="col-12">
              <Textarea
                label="Obs"
                disabled={isFetch || !dataPage.fnit_date}
                maxLength="200"
                name="fnit_obs"
                register={formRegister}
                options={InputTextRequired}
                error={formErrors.fnit_obs}
                value={String(dataPage.fnit_obs)}
                onChange={({ target }: any) => {
                  handleInput({
                    key: 'fnit_obs',
                    value: target.value,
                  })
                }}
              />
            </div>

          </div>
        </form>
      </ContentSection>
    </>
  )
}
