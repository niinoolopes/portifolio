import { useCallback, useState } from "react";
import { useContextGlobal } from "../../../context/global";
import { formFinancaCarteira } from "../../../contextData/financa";
import { collectionInitial } from "../../../contextData/globals";
import useApi, { messages } from "../../../hooks/useApi";
import { IFNCT } from "../../../types/financa";
import {
  IFinancaCarteiraGet,
  IFinancaCarteiraStore,
  IFinancaCarteiraUpdate
} from "../../../types/request";
import {
  baseMethodGet,
  baseMethodStrore,
  baseMethodUpdate
} from "../../../utils/models/baseMethods";

const baseUrl = "config/financa/carteira";

export default function CarteiraModel() {
  const { showAlert } = useContextGlobal();
  const [isFetching, setIsFetch] = useState(false);
  const { request } = useApi();

  const carteiraGet = useCallback(
    async (props: IFinancaCarteiraGet = {}) => {
      const response = await baseMethodGet({
        url: `${baseUrl}${props.fnct_id ? `/${props.fnct_id}` : ""}`,
        setFetch: setIsFetch,
        request,
        msgOnly: "error",
        msgSuccess: messages.financa.carteira.get.sucess,
        msgError: messages.financa.carteira.get.error,
        showAlert,
        params: props.params
      });

      const status = response.status;

      let item: IFNCT = formFinancaCarteira;
      let items: IFNCT[] = [];
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

  const carteiraStore = useCallback(
    async (props: IFinancaCarteiraStore) => {
      props.body.fnct_json = JSON.stringify(props.body.fnct_json || {});

      return await baseMethodStrore({
        url: `${baseUrl}`,
        setFetch: setIsFetch,
        request,
        msgSuccess: messages.financa.carteira.get.sucess,
        msgError: messages.financa.carteira.get.error,
        showAlert,
        body: props.body
      });

      /* eslint-disable-next-line react-hooks/exhaustive-deps */
    },
    [showAlert, request]
  );

  const carteiraUpdate = useCallback(
    async (props: IFinancaCarteiraUpdate) => {
      props.body.fnct_json = JSON.stringify(props.body.fnct_json || {});

      return await baseMethodUpdate({
        url: `${baseUrl}/${props.fnct_id}`,
        setFetch: setIsFetch,
        request,
        msgSuccess: messages.financa.carteira.get.sucess,
        msgError: messages.financa.carteira.get.error,
        showAlert,
        body: props.body
      });

      /* eslint-disable-next-line react-hooks/exhaustive-deps */
    },
    [showAlert, request]
  );

  return {
    isFetching,
    carteiraGet,
    carteiraStore,
    carteiraUpdate
  };
}
