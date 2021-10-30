import moment from "moment";
import { useCallback, useState } from "react";
import { useContextGlobal } from "../../context/global";
import useApi, { messages } from "../../hooks/useApi";
import { IFNIT } from "../../types/financa";
import { IFinancaAnaliseItem, IFinancaAnaliseAno } from "../../types/request";
import { IGraficoBase } from "../../types/global";
import { GraficoBar } from "../../contextData/globals";

import parseCurrency from "../../utils/parseCurrency";
import { baseMethodGet } from "../../utils/models/baseMethods";

const baseUrl = "financa";

export default function AnaliseItemModel() {
  const { showAlert } = useContextGlobal();
  const [isFetchGrupoCategoria, setIsFetchGrupoCategoria] = useState(false);
  const [isFetchAno, setIsFetchAno] = useState(false);
  const { request } = useApi();

  const analiseGrupoCategoria = useCallback(
    async (props: IFinancaAnaliseItem) => {
      setIsFetchGrupoCategoria(true);

      let url = `${baseUrl}/${props.fnct_id}/analise/grupo-categoria/${props.fntp_id}`;

      if (props.fngp_id) url += `/${props.fngp_id}`;
      if (props.fncg_id) url += `/${props.fncg_id}`;

      const response = await baseMethodGet({
        url,
        setFetch: setIsFetchGrupoCategoria,
        request,
        msgOnly: "error",
        msgSuccess: messages.financa.analiseItem.analiseGrupoCategoria.sucess,
        msgError: messages.financa.analiseItem.analiseGrupoCategoria.error,
        showAlert,
        p: true
      });

      let items = [];
      let valoresMes = [];
      let valoresPie: IGraficoBase = GraficoBar;

      if (response.status) {
        items = response.data.items
          .filter((el: { items: IFNIT[] }) => !!el.items.length)
          .map((el: { items: IFNIT[] }) => {
            el.items.map((item: IFNIT) => {
              item.fnit_date = moment(`${item.fnit_date}`).format("DD/MM/YYYY");
              item.fnit_value = parseCurrency(Number(item.fnit_value));
              return item;
            });
            return el;
          });

        valoresMes = response.data.valoresMes.map((el: any) => {
          el.value = parseCurrency(Number(el.value));
          return el;
        });
        valoresPie = response.data.valoresPie;
      }

      return {
        items,
        valoresMes,
        valoresPie
      };
      /* eslint-disable-next-line react-hooks/exhaustive-deps */
    },
    [showAlert, request]
  );

  const analiseAno = useCallback(
    async (props: IFinancaAnaliseAno) => {
      setIsFetchAno(true);

      let url = `${baseUrl}/${props.fnct_id}/analise/ano`;

      if (props?.fntp_id) url += `/${props?.fntp_id}`;
      if (props?.fngp_id) url += `/${props?.fngp_id}`;
      if (props?.fncg_id) url += `/${props?.fncg_id}`;

      const response = await baseMethodGet({
        url,
        setFetch: setIsFetchAno,
        request,
        msgOnly: "error",
        msgSuccess: messages.financa.analiseItem.analiseAno.sucess,
        msgError: messages.financa.analiseItem.analiseAno.error,
        showAlert,
        p: true
      });

      let fntp = [];
      let fngp = [];
      let fncg = [];

      if (response.status) {
        fntp = response.data.fntp;
        fngp = response.data.fngp;
        fncg = response.data.fncg;
      }

      return {
        fntp,
        fngp,
        fncg
      };
      /* eslint-disable-next-line react-hooks/exhaustive-deps */
    },
    [showAlert, request]
  );

  return {
    isFetchGrupoCategoria,
    analiseGrupoCategoria,
    isFetchAno,
    analiseAno
  };
}
