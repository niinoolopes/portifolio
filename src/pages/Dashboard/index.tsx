import React, { useEffect, useState } from 'react'
import CardValues from '../../components/card/financa/CardValues'
import Breadcrumb from '../../components-layout/Breadcrumb'
import Pie from '../../components/grafico/Pie'
import ContentSection from '../../components-layout/ContentSection'
import { useContextGlobal } from '../../context/global'
import { pageDashboardInitial } from '../../contextData/globals'
import { IPageDashboard } from '../../types/global'
import consolidadoItemModel from '../../models/financa/ConsolidadoItemModel'
import LoadingPage from '../../components/loading/LoadingPage'

export default function Dashboard() {
  const { periodo, dataFinanca } = useContextGlobal()
  const { isFetching, consolidadoItem } = consolidadoItemModel()
  const [dataPage, setDataPage] = useState<IPageDashboard>(pageDashboardInitial)

  const getDataPage = async () => {
    const { saldo, saldoPie, fntpPie, fngpReceitaPie, fngpDespesaPie } = await consolidadoItem({
      fnct_id: dataFinanca.panel,
      type: 'mes'
    })

    // Financa
    let dataPageFinanca = {
      saldo,
      saldoPie,
      fntpPie,
      fngpReceitaPie,
      fngpDespesaPie,
    }

    // setDataPage
    setDataPage((obj: IPageDashboard) => {
      return {
        ...obj,
        financa: {
          ...obj.financa,
          ...dataPageFinanca
        }
      }
    })
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
          { label: 'Home' },
        ]}
      />

      <ContentSection
        title="Finanças"
      >
        <div className="row g-2 pt-2 mb-3">
          <div className="col-12">
            <CardValues
              isFetch={isFetching}
              values={dataPage.financa.saldo}
            />
          </div>
        </div>

        <div className="row g-2">
          <div className="col-12 col-md-6 col-lg-3 p-3 p-lg-4">
            <Pie
              title="Saldos"
              value={dataPage.financa.saldoPie.value}
              label={[...dataPage.financa.saldoPie.label].splice(0, 6)}
            />
          </div>
          <div className="col-12 col-md-6 col-lg-3 p-3 p-lg-4">
            <Pie
              title="Receita/Despesa"
              value={dataPage.financa.fntpPie.value}
              label={[...dataPage.financa.fntpPie.label].splice(0, 6)}
            />
          </div>
          <div className="col-12 col-md-6 col-lg-3 p-3 p-lg-4">
            <Pie
              title="Grupos Receita"
              value={dataPage.financa.fngpReceitaPie.value}
              label={[...dataPage.financa.fngpReceitaPie.label].splice(0, 6)}
            />
          </div>
          <div className="col-12 col-md-6 col-lg-3 p-3 p-lg-4">
            <Pie
              title="Grupos Despesa"
              value={dataPage.financa.fngpDespesaPie.value}
              label={[...dataPage.financa.fngpDespesaPie.label].splice(0, 6)}
            />
          </div>
        </div>
      </ContentSection>
    </>
  )
}
