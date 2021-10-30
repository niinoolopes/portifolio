
import { useCallback, useEffect, useRef, useState } from "react"
import { FaSave, FaSyncAlt } from "react-icons/fa"
import FormCarteira from "../../../components/form/financa/FormCarteira"
import FormCarteiraConsolidar from "../../../components/form/financa/FormCarteiraConsolidar"
import Breadcrumb from "../../../components-layout/Breadcrumb"
import ContentSection from "../../../components-layout/ContentSection"
import LoadingPage from "../../../components/loading/LoadingPage"
import { useContextGlobal } from "../../../context/global"
import { formFinancaCarteira } from "../../../contextData/financa"
import useNavigate from "../../../hooks/useNavigate"
import CarteiraModel from "../../../models/config/financa/CarteiraModel"
import ConsolidadoItemModel from "../../../models/financa/ConsolidadoItemModel"
import { IFinanca, IFNCT } from "../../../types/financa"

export default function CarteiraId() {
  const isMounted = useRef(true)
  const { urlParams, urlNavigate } = useNavigate()
  const { setDataFinanca } = useContextGlobal()
  const { isFetching, carteiraGet, carteiraStore, carteiraUpdate } = CarteiraModel()
  const { consolidar } = ConsolidadoItemModel()
  const [dataPage, setDataPage] = useState<IFNCT>(formFinancaCarteira)
  const [loadPage, setLoadPage] = useState<boolean>(true)

  const handleSubmit = async (fields: IFNCT) => {
    let body: IFNCT = { ...dataPage, ...fields }

    const method: any = body.fnct_id === 'new'
      ? carteiraStore
      : carteiraUpdate

    const responseMethod = await method({
      body,
      fnct_id: body.fnct_id
    })

    if (responseMethod.status) {
      const responseGet = await carteiraGet()

      if (responseGet.status) {
        const fnct_panel = responseGet.items.find((item: IFNCT) => item.fnct_panel)

        await setDataFinanca((obj: IFinanca) => {
          return {
            ...obj,
            carteira: responseGet.items,
            panel: fnct_panel?.fnct_id || 0
          }
        })

        setDataPage(formFinancaCarteira)

        urlNavigate(`/configuracao/financa/carteira`)
      }
    }
    /* eslint-disable-next-line react-hooks/exhaustive-deps */
  }

  const handleConsoldar = async (fields: any) => {
    const periodo = fields.periodo
      ? `p=${fields.periodo}`
      : ''

    await consolidar({
      fnct_id: Number(dataPage.fnct_id),
      periodo
    })
  }

  const getId = useCallback(async () => {
    const { status, item } = await carteiraGet({ fnct_id: urlParams.id })

    if (status) {
      setDataPage(item);
    }

    setLoadPage(false)
    /* eslint-disable-next-line react-hooks/exhaustive-deps */
  }, [urlParams])

  useEffect(() => {
    if (isMounted.current) {
      if (urlParams.id) {

        getId()

      } else {

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
          { label: 'Finança carteira', url: '/configuracao/financa/carteira' },
          { label: `${dataPage.fnct_id === 'new' ? 'Adicionar' : 'Editar'}` },
        ]}
      />

      <ContentSection
        isFetching={loadPage}
        title="Carteira"
        btns={(
          <>
            <button type="submit" className="btn btn-sm" form="formCarteira"><FaSave /></button>
          </>
        )}
      >
        <FormCarteira
          dataPage={dataPage}
          handleSubmit={handleSubmit}
          isFetch={isFetching}
        />
      </ContentSection>

      <ContentSection
        isFetching={loadPage}
        title="Consolidar dados"
        btns={(
          <>
            <button type="submit" className="btn btn-sm" form="formConsolidar"><FaSyncAlt /></button>
          </>
        )}
      >
        <FormCarteiraConsolidar
          handleConsoldar={handleConsoldar}
          isFetch={isFetching}
        />
      </ContentSection>
    </>
  )
}
