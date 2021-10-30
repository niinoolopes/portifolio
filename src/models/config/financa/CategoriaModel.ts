import { useCallback, useState } from "react";
import { useContextGlobal } from "../../../context/global";
import { formFinancaCategoria } from "../../../contextData/financa";
import { collectionInitial } from "../../../contextData/globals";
import useApi, { messages } from "../../../hooks/useApi";
import { IFNCG } from "../../../types/financa";
import {
  IFinancaCategoriaGet,
  IFinancaCategoriaStore,
  IFinancaCategoriaUpdate
} from "../../../types/request";
import {
  baseMethodGet,
  baseMethodStrore,
  baseMethodUpdate
} from "../../../utils/models/baseMethods";

const baseUrl = "config/financa/categoria";

export default function CategoriaModel() {
  const { showAlert } = useContextGlobal();
  const [isFetching, setIsFetch] = useState(false);
  const { request } = useApi();

  const categoriaGet = useCallback(
    async (props: IFinancaCategoriaGet = {}) => {
      const response = await baseMethodGet({
        url: `${baseUrl}${props.fncg_id ? `/${props.fncg_id}` : ""}`,
        setFetch: setIsFetch,
        request,
        msgOnly: "error",
        msgSuccess: messages.financa.categoria.get.sucess,
        msgError: messages.financa.categoria.get.error,
        showAlert,
        params: props.params
      });

      const status = response.status;

      let item: IFNCG = formFinancaCategoria;
      let items: IFNCG[] = [];
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

  const categoriaStore = useCallback(
    async (props: IFinancaCategoriaStore) => {
      return await baseMethodStrore({
        url: `${baseUrl}`,
        setFetch: setIsFetch,
        request,
        msgSuccess: messages.financa.categoria.store.sucess,
        msgError: messages.financa.categoria.store.error,
        showAlert,
        body: props.body
      });

      /* eslint-disable-next-line react-hooks/exhaustive-deps */
    },
    [showAlert, request, setIsFetch]
  );

  const categoriaUpdate = useCallback(
    async (props: IFinancaCategoriaUpdate) => {
      return await baseMethodUpdate({
        url: `${baseUrl}/${props.fncg_id}`,
        setFetch: setIsFetch,
        request,
        msgSuccess: messages.financa.categoria.update.sucess,
        msgError: messages.financa.categoria.update.error,
        showAlert,
        body: props.body
      });

      /* eslint-disable-next-line react-hooks/exhaustive-deps */
    },
    [showAlert, request, setIsFetch]
  );

  return {
    isFetching,
    categoriaGet,
    categoriaStore,
    categoriaUpdate
  };
}
