import { useEffect, useState } from 'react'
import CardValues from '../../components/card/financa/CardValues'
import Breadcrumb from '../../components-layout/Breadcrumb'
import ContentSection from '../../components-layout/ContentSection'
import ContentSubtitle from '../../components-layout/ContentSubtitle'
import LoadingPage from '../../components/loading/LoadingPage'
import Navbar from '../../components/navabar/Navbar'
import TableItemListConsolidado from '../../components/table/financa/TableItemListConsolidado'
import { useContextGlobal } from '../../context/global'
import { pageConsolidado } from '../../contextData/financa'
import consolidadoItemModel from '../../models/financa/ConsolidadoItemModel'
import { IPageConsolidado } from '../../types/financa'

export default function ConsolidadoMes() {
  const { periodo, dataFinanca } = useContextGlobal()
  const { isFetching, consolidadoItem } = consolidadoItemModel()
  const [dataPage, setDataPage] = useState<IPageConsolidado>(pageConsolidado)

  const getDataPage = async () => {
    const data = await consolidadoItem({
      type: 'mes',
      fnct_id: dataFinanca.panel,
    })

    setDataPage(data)
  }

  useEffect(() => {
    getDataPage();
    /* eslint-disable-next-line react-hooks/exhaustive-deps */
  }, [periodo, dataFinanca])


  return (
    <>
      <LoadingPage
        isFetch={isFetching}
      />

      <Breadcrumb
        items={[
          { label: 'Home', url: '/dashboard' },
          { label: 'Finança', url: '/financa' },
          { label: 'Consolidado Mês' },
        ]}
      />

      <Navbar active="Consolidado Mês" links="financa" />

      <ContentSection>
        <CardValues
          isFetch={isFetching}
          values={dataPage.saldo}
        />
      </ContentSection>

      <ContentSection
        title="Receitas"
      >
        <div className="row g-3">
          <div className="col-12">
            <ContentSubtitle text="Grupos" />
            <TableItemListConsolidado items={dataPage.fngpReceita} />
          </div>
          <div className="col-12">
            <ContentSubtitle text="Categorias" />
            <TableItemListConsolidado items={dataPage.fncgReceita} />
          </div>
        </div>
      </ContentSection>

      <ContentSection
        title="Despesas"
      >
        <div className="row g-3">
          <div className="col-12">
            <ContentSubtitle text="Grupos" />
            <TableItemListConsolidado items={dataPage.fngpDespesa} />
          </div>
          <div className="col-12">
            <ContentSubtitle text="Categorias" />
            <TableItemListConsolidado items={dataPage.fncgDespesa} />
          </div>
        </div>
      </ContentSection>
    </>
  )
}
