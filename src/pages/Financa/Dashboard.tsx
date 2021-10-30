import { useEffect, useState } from 'react'
import CardValues from '../../components/card/financa/CardValues'
import Pie from '../../components/grafico/Pie'
import Bar from '../../components/grafico/Bar'
import Breadcrumb from '../../components-layout/Breadcrumb'
import ContentSection from '../../components-layout/ContentSection'
import LoadingPage from '../../components/loading/LoadingPage'
import Navbar from '../../components/navabar/Navbar'
import { useContextGlobal } from '../../context/global'
import consolidadoItemModel from '../../models/financa/ConsolidadoItemModel'
import { IPageDashboard } from '../../types/financa'
import { pageDashboard } from '../../contextData/financa'
import ContentSubtitle from '../../components-layout/ContentSubtitle'
import CardTop3 from '../../components/card/financa/CardTop3'

export default function Dashboard() {
  const { periodo, dataFinanca } = useContextGlobal()
  const { isFetching, consolidadoItem } = consolidadoItemModel()
  const [dataPage, setDataPage] = useState<IPageDashboard>(pageDashboard)

  const getDataPage = async () => {

    const {
      saldo,
      fncgDespesaPie,
      fncgReceitaPie,
      fngpDespesaPie,
      fngpReceitaPie,
      fntpPie,
      saldoPie,
      fngpReceitaMax,
      fngpDespesaMax,
      fncgReceitaMax,
      fncgDespesaMax
    } = await consolidadoItem({
      type: 'mes',
      fnct_id: dataFinanca.panel,
    })

    setDataPage({
      saldo,
      fncgDespesaPie,
      fncgReceitaPie,
      fngpDespesaPie,
      fngpReceitaPie,
      fntpPie,
      saldoPie,
      fngpReceitaMax,
      fngpDespesaMax,
      fncgReceitaMax,
      fncgDespesaMax
    });
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
          { label: 'Finança' },
        ]}
      />

      <Navbar active="Dashboard" links="financa" />

      <ContentSection>
        <CardValues
          isFetch={isFetching}
          values={dataPage.saldo}
        />
      </ContentSection>

      <ContentSection>
        <ContentSubtitle text="Top 3" />
        <div className="d-flex flex-md-wrap overflow-x-auto">
          {
            [
              { data: dataPage.fngpReceitaMax, title: 'Grupo Receita' },
              { data: dataPage.fngpDespesaMax, title: 'Grupo Despesa' },
              { data: dataPage.fncgReceitaMax, title: 'Categoria Receita' },
              { data: dataPage.fncgDespesaMax, title: 'Categoria Despesa' },
            ].map(({ data, title }, i) => (
              <div
                key={`${i}-item-CardTop3`}
                className="col-9 col-md-6 col-lg-3 me-2 m-md-0 p-md-1"
              >
                <p className="m-0">{title}</p>
                {data.map((el, j) => <CardTop3 key={`${i}-${j}-item-CardTop3`} isFetch={isFetching} item={el} />)}
              </div>
            ))
          }
        </div>
      </ContentSection>

      <ContentSection>
        <div className="d-flex flex-md-wrap overflow-x-auto">
          {
            [
              { data: dataPage.saldoPie, title: 'Saldos' },
              { data: dataPage.fntpPie, title: 'Receita/Despesa' },
              { data: dataPage.fngpReceitaPie, title: 'Grupos Receita' },
              { data: dataPage.fngpDespesaPie, title: 'Grupos Despesa' },
            ].map(({ data, title }, i) => (
              <div
                key={`${i}-item-Pie`}
                className="col-9 col-md-6 col-lg-3 me-2 m-md-0 p-md-3 p-lg-4"
              >
                <Pie
                  title={title}
                  value={data.value}
                  label={[...data.label].splice(0, 6)}
                />
              </div>
            ))
          }
        </div>
      </ContentSection>

      <ContentSection>
        <div className="row g-2">
          <div className="col-12 col-lg-6">
            <Bar
              title="Grupos Receita"
              value={dataPage.fngpReceitaPie.value}
              label={dataPage.fngpReceitaPie.label}
            />
          </div>
          <div className="col-12 col-lg-6">
            <Bar
              title="Grupos Despesa"
              value={dataPage.fngpDespesaPie.value}
              label={dataPage.fngpDespesaPie.label}
            />
          </div>
        </div>
      </ContentSection>

      <ContentSection>
        <div className="row g-2">
          <div className="col-12 col-lg-6">
            <Bar
              title="Categorias Receita"
              value={dataPage.fncgReceitaPie.value}
              label={dataPage.fncgReceitaPie.label}
            />
          </div>
          <div className="col-12 col-lg-6">
            <Bar
              title="Categorias Despesa"
              value={dataPage.fncgDespesaPie.value}
              label={dataPage.fncgDespesaPie.label}
            />
          </div>
        </div>
      </ContentSection>
    </>
  )
}
