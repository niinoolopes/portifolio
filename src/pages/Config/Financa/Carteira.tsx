import { useCallback, useEffect, useState } from "react";
import { FaPlusCircle } from "react-icons/fa";
import Breadcrumb from "../../../components-layout/Breadcrumb";
import ContentSection from "../../../components-layout/ContentSection";
import LoadingPage from "../../../components/loading/LoadingPage";
import SearchCarteira from "../../../components/search/financa/SearchCarteira";
import TableCarteira from "../../../components/table/financa/TableCarteira";
import Pagination from "../../../components/table/Pagination";
import { formSearchFinancaCarteira } from "../../../contextData/financa";
import { dataCollectionInitial } from "../../../contextData/globals";
import useNavigate from "../../../hooks/useNavigate";
import CarteiraModel from "../../../models/config/financa/CarteiraModel";
import { IFNCT, IformSearchCarteira } from "../../../types/financa";
import { ICollection } from "../../../types/global";
import parseObjectToString from "../../../utils/parseObjectToString";

type IDataPage = {
  items: IFNCT[]
  pagination: ICollection
}

export default function Carteira() {
  const { urlNavigate } = useNavigate()
  const { isFetching, carteiraGet } = CarteiraModel()
  const [formSearch, setFormSearch] = useState<IformSearchCarteira>(formSearchFinancaCarteira)
  const [dataPage, setDataPage] = useState<IDataPage>(dataCollectionInitial)

  const getDataPage = useCallback(async (search = {}) => {

    let params = ''
    params += parseObjectToString(search, { required: true })

    const { items, pagination } = await carteiraGet({ params })

    setDataPage({ items, pagination })
    /* eslint-disable-next-line react-hooks/exhaustive-deps */
  }, [])

  useEffect(() => {
    getDataPage(formSearch);
    /* eslint-disable-next-line react-hooks/exhaustive-deps */
  }, [formSearch])


  return (
    <>
      <LoadingPage
        isFetch={isFetching}
      />

      <Breadcrumb
        items={[
          { label: 'Home', url: '/dashboard' },
          { label: 'Configuração', url: '/configuracao' },
          { label: 'Finança carteira' },
        ]}
      />

      <ContentSection
        title="Lista de carteiras"
        btns={(
          <>
            <button className="btn btn-sm" onClick={() => urlNavigate('/configuracao/financa/carteira/adm')}><FaPlusCircle size="18" /></button>
          </>
        )}
      >

        <SearchCarteira
          set={setFormSearch}
          form={formSearch}
        />

        <TableCarteira
          items={dataPage.items}
        />

        <Pagination
          set={setFormSearch}
          total={dataPage?.pagination.total}
          from={dataPage?.pagination.from}
          to={dataPage?.pagination.to}
          per_page={dataPage?.pagination.per_page}
          page={dataPage?.pagination.page}
          last_page={dataPage?.pagination.last_page}
        />
      </ContentSection>
    </>
  )
}
