import { useEffect, useRef, useState } from "react"
import Breadcrumb from "../../components-layout/Breadcrumb"
import ContentSection from "../../components-layout/ContentSection"
import Navbar from "../../components/navabar/Navbar"
import { useContextGlobal } from "../../context/global"
import analiseItemModel from "../../models/financa/AnaliseItemModel"
import { formSearchFinancaAnaliseGrupoCategoria, pageAnaliseGrupoCategoria } from "../../contextData/financa"
import { IFNGP, IformSearchAnaliseGrupoCategoria, IPageAnaliseGrupoCategoria } from "../../types/financa"
import SearchAnaliseGrupoCategoria from "../../components/search/financa/SearchAnaliseGrupoCategoria"
import Line from '../../components/grafico/Line'
import LoadingPage from "../../components/loading/LoadingPage"
import TableAnaliseGrupoCategoria from "../../components/table/financa/TableAnaliseGrupoCategoria"
import TableItem from "../../components/table/financa/TableItem"
import useNavigate from "../../hooks/useNavigate"
import Accordion from "../../components/accordion/Accordion"

export default function AnaliseGrupoCategoria() {
  const { urlParams, urlSearch } = useNavigate()

  const { dataFinanca, } = useContextGlobal()
  const { isFetchGrupoCategoria, analiseGrupoCategoria } = analiseItemModel()
  const [dataPage, setDataPage] = useState<IPageAnaliseGrupoCategoria>(pageAnaliseGrupoCategoria)
  const [formSearch, setFormSearch] = useState<IformSearchAnaliseGrupoCategoria>(() => {

    const firstGrupo = dataFinanca.grupo.find((item: IFNGP) => +item.fntp_id === 2 && +item.fnct_id === +dataFinanca.panel).fngp_id

    const {
      fntp_id: fntp_initial,
      fngp_id: fngp_initial,
      fncg_id: fncg_initial,
    } = formSearchFinancaAnaliseGrupoCategoria

    const fntp_url = urlSearch('fntp_id')
    const fngp_url = urlSearch('fngp_id') || false
    const fncg_url = urlSearch('fncg_id') || false

    return {
      fntp_id: +(fntp_url || fntp_initial),
      fngp_id: +(fngp_url || +firstGrupo || fngp_initial),
      fncg_id: +(fncg_url || fncg_initial)
    }
  })
  const idsUrl = useRef('')

  const getDataPage = async (params: { fntp_id?: number, fngp_id?: number, fncg_id?: number } = {}) => {

    idsUrl.current = ''
    idsUrl.current += `fntp_id=${params.fntp_id}`
    idsUrl.current += params.fngp_id ? `&fngp_id=${params.fngp_id}` : ''
    idsUrl.current += params.fncg_id ? `&fncg_id=${params.fncg_id}` : ''

    const data = await analiseGrupoCategoria({
      fnct_id: dataFinanca.panel,
      fntp_id: params.fntp_id || 0,
      fngp_id: params.fngp_id || 0,
      fncg_id: params.fncg_id || 0
    })

    setDataPage(data)
  }

  useEffect(() => {
    const { fntp_id, fngp_id, fncg_id } = formSearch

    if (!!fntp_id) {

      getDataPage({
        fntp_id: Number(fntp_id),
        fngp_id: Number(fngp_id),
        fncg_id: Number(fncg_id)
      })
    }
    /* eslint-disable-next-line react-hooks/exhaustive-deps */
  }, [formSearch])

  useEffect(() => {
    const fntp_id = urlSearch('fntp_id')
    const fngp_id = urlSearch('fngp_id') || false
    const fncg_id = urlSearch('fncg_id') || false

    if (!!fntp_id) {
      getDataPage({
        fntp_id: Number(fntp_id),
        fngp_id: Number(fngp_id),
        fncg_id: Number(fncg_id)
      })
    }
    /* eslint-disable-next-line react-hooks/exhaustive-deps */
  }, [urlParams])


  return (
    <>
      <LoadingPage
        isFetch={isFetchGrupoCategoria}
      />

      <Breadcrumb
        items={[
          { label: 'Home', url: '/dashboard' },
          { label: 'Finança', url: '/financa' },
          { label: 'Analise Grupo/Categoria' },
        ]}
      />

      <Navbar active="Analise" links="financa" />

      <ContentSection>
        <SearchAnaliseGrupoCategoria
          set={setFormSearch}
          form={formSearch}
        />
      </ContentSection>

      <ContentSection>
        <div className="row">
          <div className="col-12 col-md-3 col-xl-2">
            <TableAnaliseGrupoCategoria
              isFetch={isFetchGrupoCategoria}
              items={dataPage.valoresMes}
            />
          </div>
          <div className="col-12 col-md-9 col-xl-10">
            <Line
              title="Grafico Mêses"
              value={dataPage.valoresPie.value}
              label={dataPage.valoresPie.label}
            />
          </div>
        </div>
      </ContentSection>

      <ContentSection>

        <div className="row">
          {dataPage.items?.map((item, i) => (
            <div key={item.name} className={`col-12 ${dataPage.items.length !== (i + 1) ? 'mb-3' : ''}`}>
              <Accordion title={item.name} >
                <TableItem
                  from={`analise&${idsUrl.current}`}
                  items={item.items}
                />
              </Accordion>
            </div>
          ))}
        </div>

      </ContentSection>

    </>
  )
}
