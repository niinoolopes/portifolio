import { useEffect, useState } from "react"
import Breadcrumb from "../../components-layout/Breadcrumb"
import ContentSection from "../../components-layout/ContentSection"
import Navbar from "../../components/navabar/Navbar"
import { useContextGlobal } from "../../context/global"
import analiseItemModel from "../../models/financa/AnaliseItemModel"
import { formSearchFinancaAnaliseAno, pageAnaliseAno } from "../../contextData/financa"
import { IFNGP, IformSearchAnaliseAno, IPageAnaliseAno } from "../../types/financa"
import LoadingPage from "../../components/loading/LoadingPage"
import ContentSubtitle from "../../components-layout/ContentSubtitle"
import TableAnaliseAno from "../../components/table/financa/TableAnaliseAno"
import SearchAnaliseAno from "../../components/search/financa/SearchAnaliseAno"

export default function AnaliseAno() {
  const { periodo, dataFinanca, } = useContextGlobal()
  const { isFetchAno, analiseAno } = analiseItemModel()
  const [dataPage, setDataPage] = useState<IPageAnaliseAno>(pageAnaliseAno)
  const [formSearch, setFormSearch] = useState<IformSearchAnaliseAno>(() => {

    const fngp = dataFinanca.grupo.find((el: IFNGP) => +el.fnct_id === +dataFinanca.panel && +el.fntp_id === 2)

    return {
      ...formSearchFinancaAnaliseAno,
      fngp_id: fngp.fngp_id
    }
  })

  const getDataPage = async (params: { fntp_id?: number, fngp_id?: number, fncg_id?: number } = {}) => {

    const { fntp, fngp, fncg } = await analiseAno({
      fnct_id: dataFinanca.panel,
      fntp_id: params.fntp_id || 0,
      fngp_id: params.fngp_id || 0,
      fncg_id: params.fncg_id || 0
    })

    setDataPage({
      fntpAno: fntp,
      fngpAno: fngp,
      fncgAno: fncg,
    })
  }

  useEffect(() => {
    const fngp = dataFinanca.grupo.find((el: IFNGP) => +el.fnct_id === +dataFinanca.panel && +el.fntp_id === 2)

    getDataPage({
      fntp_id: 2,
      fngp_id: fngp.fngp_id
    })
    /* eslint-disable-next-line react-hooks/exhaustive-deps */
  }, [periodo, dataFinanca])

  useEffect(() => {
    const { fntp_id, fngp_id, fncg_id } = formSearch

    getDataPage({
      fntp_id: Number(fntp_id),
      fngp_id: Number(fngp_id),
      fncg_id: Number(fncg_id)
    })
    /* eslint-disable-next-line react-hooks/exhaustive-deps */
  }, [formSearch])

  return (
    <>
      <LoadingPage
        isFetch={isFetchAno}
      />

      <Breadcrumb
        items={[
          { label: 'Home', url: '/dashboard' },
          { label: 'Finança', url: '/financa' },
          { label: 'Analise ano' },
        ]}
      />

      <Navbar active="Analise Ano" links="financa" />

      <ContentSection>
        <SearchAnaliseAno
          set={setFormSearch}
          form={formSearch}
        />
      </ContentSection>

      <ContentSection>
        <ContentSubtitle text="Tipo" />
        <div className="row g-2">
          <div className="col-12">
            <TableAnaliseAno
              isFetch={isFetchAno}
              items={dataPage.fntpAno}
            />
          </div>
        </div>
      </ContentSection>

      <ContentSection>
        <ContentSubtitle text="Grupos" />
        <div className="row g-2">
          <div className="col-12">
            <TableAnaliseAno
              isFetch={isFetchAno}
              items={dataPage.fngpAno}
            />
          </div>
        </div>
      </ContentSection>

      <ContentSection>
        <ContentSubtitle text="Categorias" />
        <div className="row g-2">
          <div className="col-12">
            <TableAnaliseAno
              isFetch={isFetchAno}
              items={dataPage.fncgAno}
            />
          </div>
        </div>
      </ContentSection>

    </>
  )
}
