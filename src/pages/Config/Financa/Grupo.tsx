import { useCallback, useEffect, useState } from "react";
import { FaPlusCircle } from "react-icons/fa";
import Breadcrumb from "../../../components-layout/Breadcrumb";
import ContentSection from "../../../components-layout/ContentSection";
import LoadingPage from "../../../components/loading/LoadingPage";
import SearchGrupo from "../../../components/search/financa/SearchGrupo";
import TableGrupo from "../../../components/table/financa/TableGrupo";
import Pagination from "../../../components/table/Pagination";
import { useContextFinanca } from "../../../context/financa";
import { formSearchFinancaGrupo } from "../../../contextData/financa";
import { dataCollectionInitial } from "../../../contextData/globals";
import useNavigate from "../../../hooks/useNavigate";
import GrupoModel from "../../../models/config/financa/GrupoModel";
import { IFNGP, IformSearchGrupo } from "../../../types/financa";
import { ICollection } from "../../../types/global";
import parseObjectToString from "../../../utils/parseObjectToString";

type IDataPage = {
  items: IFNGP[]
  pagination: ICollection
}

export default function Grupo() {
  const { urlNavigate } = useNavigate()
  const { getCarteiraPanel } = useContextFinanca()
  const { isFetching, grupoGet } = GrupoModel()
  const [formSearch, setFormSearch] = useState<IformSearchGrupo>(() => {
    return {
      ...formSearchFinancaGrupo,
      fnct_id: getCarteiraPanel.fnct_id
    }
  })
  const [dataPage, setDataPage] = useState<IDataPage>(dataCollectionInitial)

  const getDataPage = useCallback(async (search = {}) => {

    let params = ''
    params += parseObjectToString(search, { required: true })

    const { items, pagination } = await grupoGet({ params })

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
          { label: 'Finança grupo' },
        ]}
      />


      <ContentSection
        title="Lista de grupos"
        btns={(
          <>
            <button className="btn btn-sm" onClick={() => urlNavigate('/configuracao/financa/grupo/adm')}><FaPlusCircle size="18" /></button>
          </>
        )}
      >

        <SearchGrupo
          set={setFormSearch}
          form={formSearch}
        />

        <TableGrupo
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
