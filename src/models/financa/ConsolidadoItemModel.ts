import { useCallback, useState } from "react";
import { useContextGlobal } from "../../context/global";
import { ItemsTop3Initial, Saldo } from "../../contextData/financa";
import { GraficoPie } from "../../contextData/globals";
import useApi, { messages } from "../../hooks/useApi";
import {
  IFinancaConsolidadoItem,
  IFinancaConsolidar
} from "../../types/request";
import { baseMethodGet } from "../../utils/models/baseMethods";

const baseUrl = "financa";

export default function ConsolidadoItemModel() {
  const { showAlert } = useContextGlobal();
  const [isFetching, setIsFetch] = useState(false);
  const { request } = useApi();

  const consolidar = useCallback(
    async (props: IFinancaConsolidar) => {
      return await baseMethodGet({
        url: `${baseUrl}/${props.fnct_id}/consolidate/item`,
        setFetch: setIsFetch,
        request,
        msgSuccess: messages.financa.consolidadoItem.consolidar.sucess,
        msgError: messages.financa.consolidadoItem.consolidar.error,
        showAlert,
        params: props.periodo || ""
      });

      /* eslint-disable-next-line react-hooks/exhaustive-deps */
    },
    [showAlert, request]
  );

  const consolidadoItem = useCallback(
    async (props: IFinancaConsolidadoItem) => {
      const response = await baseMethodGet({
        url: `${baseUrl}/${props.fnct_id}/consolidate/item/${props.type}`,
        setFetch: setIsFetch,
        request,
        msgOnly: "error",
        msgSuccess: messages.financa.consolidadoItem.consolidadoItem.sucess,
        msgError: messages.financa.consolidadoItem.consolidadoItem.error,
        showAlert,
        p: true
      });

      const status = response.status;
      const {
        saldo: _saldo,
        saldoPie: _saldoPie,
        fntp: _fntp,
        fntpPie: _fntpPie,
        fncgDespesa: _fncgDespesa,
        fncgDespesaPie: _fncgDespesaPie,
        fncgReceita: _fncgReceita,
        fncgReceitaPie: _fncgReceitaPie,
        fngpDespesa: _fngpDespesa,
        fngpDespesaPie: _fngpDespesaPie,
        fngpReceita: _fngpReceita,
        fngpReceitaPie: _fngpReceitaPie,
        fngpReceitaMax: _fngpReceitaMax,
        fngpDespesaMax: _fngpDespesaMax,
        fncgReceitaMax: _fncgReceitaMax,
        fncgDespesaMax: _fncgDespesaMax
      } = response.data;

      const saldo = status && _saldo ? _saldo : Saldo;
      const saldoPie = status && _saldoPie ? _saldoPie : GraficoPie;

      const fntp = status && _fntp ? _fntp : [];
      const fntpPie = status && _fntpPie ? _fntpPie : GraficoPie;

      const fncgDespesa = status && _fncgDespesa ? _fncgDespesa : [];
      const fncgDespesaPie =
        status && _fncgDespesaPie ? _fncgDespesaPie : GraficoPie;

      const fncgReceita = status && _fncgReceita ? _fncgReceita : [];
      const fncgReceitaPie =
        status && _fncgReceitaPie ? _fncgReceitaPie : GraficoPie;

      const fngpDespesa = status && _fngpDespesa ? _fngpDespesa : [];
      const fngpDespesaPie =
        status && _fngpDespesaPie ? _fngpDespesaPie : GraficoPie;

      const fngpReceita = status && _fngpReceita ? _fngpReceita : [];
      const fngpReceitaPie =
        status && _fngpReceitaPie ? _fngpReceitaPie : GraficoPie;

      const fngpReceitaMax =
        status && _fngpReceitaMax ? _fngpReceitaMax : ItemsTop3Initial;
      const fngpDespesaMax =
        status && _fngpDespesaMax ? _fngpDespesaMax : ItemsTop3Initial;

      const fncgReceitaMax =
        status && _fncgReceitaMax ? _fncgReceitaMax : ItemsTop3Initial;
      const fncgDespesaMax =
        status && _fncgDespesaMax ? _fncgDespesaMax : ItemsTop3Initial;

      return {
        status,
        saldo,
        saldoPie,
        fntp,
        fntpPie,
        fncgDespesa,
        fncgDespesaPie,
        fncgReceita,
        fncgReceitaPie,
        fngpDespesa,
        fngpDespesaPie,
        fngpReceita,
        fngpReceitaPie,
        fngpReceitaMax,
        fngpDespesaMax,
        fncgReceitaMax,
        fncgDespesaMax
      };
      /* eslint-disable-next-line react-hooks/exhaustive-deps */
    },
    [showAlert, request]
  );

  return {
    isFetching,
    consolidadoItem,
    consolidar
  };
}
