import { useCallback, useState } from "react";
import { useContextGlobal } from "../../../context/global";
import { formFinancaGrupo } from "../../../contextData/financa";
import { collectionInitial } from "../../../contextData/globals";
import useApi, { messages } from "../../../hooks/useApi";
import { IFNGP } from "../../../types/financa";
import {
  IFinancaGrupoGet,
  IFinancaGrupoStore,
  IFinancaGrupoUpdate
} from "../../../types/request";
import {
  baseMethodGet,
  baseMethodStrore,
  baseMethodUpdate
} from "../../../utils/models/baseMethods";

const baseUrl = "config/financa/grupo";

export default function GrupoModel() {
  const { showAlert } = useContextGlobal();
  const [isFetching, setIsFetch] = useState(false);
  const { request } = useApi();

  const grupoGet = useCallback(
    async (props: IFinancaGrupoGet = {}) => {
      const response = await baseMethodGet({
        url: `${baseUrl}${props.fngp_id ? `/${props.fngp_id}` : ""}`,
        setFetch: setIsFetch,
        request,
        msgOnly: "error",
        msgSuccess: messages.financa.grupo.get.sucess,
        msgError: messages.financa.grupo.get.error,
        showAlert,
        params: props.params
      });

      const status = response.status;

      let item: IFNGP = formFinancaGrupo;
      let items: IFNGP[] = [];
      let pagination = collectionInitial;

      if (status) {
        const isArray =
          response.data?.data && Array.isArray(response.data?.data);

        if (isArray) {
          items = response.data.data;
        } else {
          item = response.data;
        }

        pagination.page = response.current_page;
        pagination.from = response.from;
        pagination.last_page = response.last_page;
        pagination.per_page = response.per_page;
        pagination.to = response.to;
        pagination.total = response.total;
      }

      return {
        status,
        item,
        items,
        pagination
      };

      /* eslint-disable-next-line react-hooks/exhaustive-deps */
    },
    [showAlert, request, setIsFetch]
  );

  const grupoStore = useCallback(
    async (props: IFinancaGrupoStore) => {
      return await baseMethodStrore({
        url: `${baseUrl}`,
        setFetch: setIsFetch,
        request,
        msgSuccess: messages.financa.grupo.store.sucess,
        msgError: messages.financa.grupo.store.error,
        showAlert,
        body: props.body
      });

      /* eslint-disable-next-line react-hooks/exhaustive-deps */
    },
    [showAlert, request, setIsFetch]
  );

  const grupoUpdate = useCallback(
    async (props: IFinancaGrupoUpdate) => {
      return await baseMethodUpdate({
        url: `${baseUrl}/${props.fngp_id}`,
        setFetch: setIsFetch,
        request,
        msgSuccess: messages.financa.grupo.update.sucess,
        msgError: messages.financa.grupo.update.error,
        showAlert,
        body: props.body
      });

      /* eslint-disable-next-line react-hooks/exhaustive-deps */
    },
    [showAlert, request, setIsFetch]
  );

  return {
    isFetching,
    grupoGet,
    grupoStore,
    grupoUpdate
  };
}
