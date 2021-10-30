import { useEffect, useState } from "react"
import Breadcrumb from "../../components-layout/Breadcrumb"
import ContentSection from "../../components-layout/ContentSection"
import LoadingPage from "../../components/loading/LoadingPage"
import Navbar from "../../components/navabar/Navbar"
import SearchItem from "../../components/search/financa/SearchItem"
import TableItem from '../../components/table/financa/TableItem'
import Pagination from "../../components/table/Pagination"
import { useContextGlobal } from "../../context/global"
import { formSearchExtrato } from "../../contextData/financa"
import { dataCollectionInitial } from "../../contextData/globals"
import ItemModel from "../../models/financa/ItemModel"
import { IFNIT, IformSearchExtrato } from "../../types/financa"
import { ICollection } from "../../types/global"
import parseObjectToString from "../../utils/parseObjectToString"

type IDataPage = {
  items: IFNIT[]
  pagination: ICollection
}

export default function Extrato() {
  const { periodo, dataFinanca } = useContextGlobal()
  const { isFetch, itemGet } = ItemModel()
  const [formSearch, setFormSearch] = useState<IformSearchExtrato>(formSearchExtrato)
  const [dataPage, setDataPage] = useState<IDataPage>(dataCollectionInitial)

  const getDataPage = async (search = {}) => {

    let params = ''
    params += parseObjectToString(search, { required: true })

    let fnct_id = dataFinanca.panel

    const { items, pagination } = await itemGet({ fnct_id, params })

    setDataPage({ items, pagination })
  }

  useEffect(() => {
    getDataPage(formSearch);
    /* eslint-disable-next-line react-hooks/exhaustive-deps */
  }, [periodo, dataFinanca, formSearch])


  return (
    <>
      <LoadingPage
        isFetch={isFetch}
      />

      <Breadcrumb
        items={[
          { label: 'Home', url: '/dashboard' },
          { label: 'Finança', url: '/financa' },
          { label: 'Extrato' },
        ]}
      />

      <Navbar active="Extrato" links="financa" />

      <ContentSection>

        <SearchItem
          set={setFormSearch}
          form={formSearch}
        />

        <TableItem
          from="extrato"
          items={dataPage?.items || []}
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
