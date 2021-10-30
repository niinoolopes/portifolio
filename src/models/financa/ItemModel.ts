import moment from "moment";
import { useCallback, useState } from "react";
import { useContextGlobal } from "../../context/global";
import useApi, { messages } from "../../hooks/useApi";
import { IFNIT } from "../../types/financa";
import {
  IFinancaItemGet,
  IFinancaItemStore,
  IFinancaItemUpdate,
  IFinancaItemDelete
} from "../../types/request";
import { collectionInitial } from "../../contextData/globals";
import { formFinancaItem } from "../../contextData/financa";
import parseCurrency from "../../utils/parseCurrency";
import {
  baseMethodGet,
  baseMethodStrore,
  baseMethodUpdate,
  baseMethodDelete
} from "../../utils/models/baseMethods";

export default function ItemModel() {
  const { showAlert } = useContextGlobal();
  const [isFetch, setIsFetch] = useState(false);
  const { request } = useApi();

  const itemGet = useCallback(
    async (props: IFinancaItemGet = { fnct_id: 0 }) => {
      const response = await baseMethodGet({
        url: `financa/${props.fnct_id}/item${
          props.fnit_id ? `/${props.fnit_id}` : ""
        }`,
        setFetch: setIsFetch,
        request,
        msgOnly: "error",
        msgSuccess: messages.financa.item.get.sucess,
        msgError: messages.financa.item.get.error,
        showAlert,
        params: props.params,
        p: true
      });

      const status = response.status;

      let item: IFNIT = formFinancaItem;
      let items: IFNIT[] = [];
      let pagination = collectionInitial;

      if (status) {
        const isArray =
          response.data?.data && Array.isArray(response.data?.data);

        if (isArray) {
          items = response.data.data.map((item: IFNIT) => {
            item.fnit_date = moment(`${item.fnit_date}`).format("DD/MM/YYYY");
            item.fnit_value = parseCurrency(Number(item.fnit_value));
            return item;
          });
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

  const itemStore = useCallback(
    async (props: IFinancaItemStore) => {
      return await baseMethodStrore({
        url: `financa/${props.fnct_id}/item`,
        setFetch: setIsFetch,
        request,
        msgSuccess: messages.financa.item.store.sucess,
        msgError: messages.financa.item.store.error,
        showAlert,
        body: props.body
      });

      /* eslint-disable-next-line react-hooks/exhaustive-deps */
    },
    [showAlert, request, setIsFetch]
  );

  const itemUpdate = useCallback(
    async (props: IFinancaItemUpdate) => {
      return await baseMethodUpdate({
        url: `financa/${props.fnct_id}/item/${props.fnit_id}`,
        setFetch: setIsFetch,
        request,
        msgSuccess: messages.financa.item.update.sucess,
        msgError: messages.financa.item.update.error,
        showAlert,
        body: props.body
      });

      /* eslint-disable-next-line react-hooks/exhaustive-deps */
    },
    [showAlert, request, setIsFetch]
  );

  const itemDelete = useCallback(
    async (props: IFinancaItemDelete) => {
      return await baseMethodDelete({
        url: `financa/${props.fnct_id}/item/${props.fnit_id}`,
        setFetch: setIsFetch,
        request,
        msgSuccess: messages.financa.item.delete.sucess,
        msgError: messages.financa.item.delete.error,
        showAlert
      });

      /* eslint-disable-next-line react-hooks/exhaustive-deps */
    },
    [showAlert, request, setIsFetch]
  );

  return {
    isFetch,
    itemGet,
    itemStore,
    itemUpdate,
    itemDelete
  };
}
