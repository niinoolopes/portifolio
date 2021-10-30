import { useCallback, useEffect, useState } from "react";
import { FaPlusCircle } from "react-icons/fa";
import Breadcrumb from "../../../components-layout/Breadcrumb";
import ContentSection from "../../../components-layout/ContentSection";
import LoadingPage from "../../../components/loading/LoadingPage";
import SearchCategoria from "../../../components/search/financa/SearchCategoria";
import TableCategoria from "../../../components/table/financa/TableCategoria";
import { useContextFinanca } from "../../../context/financa";
import { formSearchFinancaCategoria } from "../../../contextData/financa";
import { dataCollectionInitial } from "../../../contextData/globals";
import useNavigate from "../../../hooks/useNavigate";
import CategoriaModel from "../../../models/config/financa/CategoriaModel";
import { IFNCG, IformSearchCategoria } from "../../../types/financa";
import { ICollection } from "../../../types/global";
import parseObjectToString from "../../../utils/parseObjectToString";

type IDataPage = {
  items: IFNCG[]
  pagination: ICollection
}

export default function Categoria() {
  const { urlNavigate } = useNavigate()
  const { getCarteiraPanel } = useContextFinanca()
  const { isFetching, categoriaGet } = CategoriaModel()
  const [formSearch, setFormSearch] = useState<IformSearchCategoria>(() => {
    return {
      ...formSearchFinancaCategoria,
      fnct_id: getCarteiraPanel.fnct_id
    }
  })
  const [dataPage, setDataPage] = useState<IDataPage>(dataCollectionInitial)

  const getDataPage = useCallback(async (search = {}) => {

    let params = ''
    params += parseObjectToString(search, { required: true })

    const { items, pagination } = await categoriaGet({ params })

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
          { label: 'Finança categoria' },
        ]}
      />

      <ContentSection
        title="Lista de categorias"
        btns={(
          <>
            <button className="btn btn-sm" onClick={() => urlNavigate('/configuracao/financa/categoria/adm')}><FaPlusCircle size="18" /></button>
          </>
        )}
      >

        <SearchCategoria
          set={setFormSearch}
          form={formSearch}
        />

        <TableCategoria
          items={dataPage.items}
        />
      </ContentSection>
    </>
  )
}
