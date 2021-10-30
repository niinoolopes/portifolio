import moment from "moment";
import {
  IFNCG,
  IFNCT,
  IFNGP,
  IFNIT,
  IformSearchAnaliseAno,
  IformSearchAnaliseGrupoCategoria,
  IformSearchCarteira,
  IformSearchCategoria,
  IformSearchExtrato,
  IformSearchGrupo,
  IItemsTop3,
  IPageAnaliseAno,
  IPageAnaliseGrupoCategoria,
  IPageConsolidado,
  IPageDashboard,
  IPageLista,
  IPageListaItem,
  ISaldo
} from "../types/financa";

import { collectionInitial, GraficoBar, GraficoPie } from "./globals";

// CONFIG
export const formFinancaCarteira: IFNCT = {
  fnct_id: "new",
  fnct_description: "",
  fnct_json: "{}",
  fnct_panel: 0,
  fnct_enable: 1
};
export const formFinancaGrupo: IFNGP = {
  fngp_id: "new",
  fngp_description: "",
  fngp_enable: 1,
  fngp_fechamento: 0,
  fnct_id: 0,
  fntp_id: 0
};
export const formFinancaCategoria: IFNCG = {
  fncg_id: "new",
  fncg_description: "",
  fncg_obs: "",
  fncg_enable: 1,
  fncg_add_cofre: 0,
  fncg_fechamento: 0,
  fnct_id: 0,
  fngp_id: 0,
  fntp_id: 1
};

// COMPONENTS
export const Saldo: ISaldo = {
  receita: 0,
  despesa: 0,
  sobra: 0,
  estimado: 0
};
export const ItemsTop3Initial: IItemsTop3[] = [
  { total: 0, name: "" },
  { total: 0, name: "" },
  { total: 0, name: "" }
];

// PAGE
export const pageDashboard: IPageDashboard = {
  saldo: Saldo,
  fncgDespesaPie: GraficoPie,
  fncgReceitaPie: GraficoPie,
  fngpDespesaPie: GraficoPie,
  fngpReceitaPie: GraficoPie,
  fntpPie: GraficoPie,
  saldoPie: GraficoPie,
  fncgDespesaMax: ItemsTop3Initial,
  fncgReceitaMax: ItemsTop3Initial,
  fngpDespesaMax: ItemsTop3Initial,
  fngpReceitaMax: ItemsTop3Initial
};
export const pageAnaliseGrupoCategoria: IPageAnaliseGrupoCategoria = {
  items: [],
  valoresMes: [],
  valoresPie: GraficoBar
};
export const pageAnaliseAno: IPageAnaliseAno = {
  fntpAno: [],
  fngpAno: [],
  fncgAno: []
};
export const pageConsolidado: IPageConsolidado = {
  saldo: {
    receita: 0,
    despesa: 0,
    sobra: 0,
    estimado: 0
  },
  saldoPie: GraficoBar,

  fntp: [],
  fntpPie: GraficoBar,

  fngpReceita: [],
  fngpDespesa: [],
  fngpReceitaPie: GraficoBar,
  fngpDespesaPie: GraficoBar,

  fncgReceita: [],
  fncgDespesa: [],
  fncgReceitaPie: GraficoBar,
  fncgDespesaPie: GraficoBar
};
export const pageListaItem: IPageListaItem = {
  fnit_value: 0,
  fnit_date: moment().format("YYYY-MM-DD"),
  fnit_obs: "",
  fnit_enable: 1,
  fnct_id: 0,
  fngp_id: 0,
  fngp: {
    fngp_id: "new",
    fngp_description: "",
    fngp_enable: 1,
    fngp_fechamento: 0,
    fnct_id: 0,
    fntp_id: 0
  },
  fncg_id: 0,
  fncg: {
    fncg_id: "new",
    fncg_description: "",
    fncg_obs: "",
    fncg_enable: 1,
    fncg_add_cofre: 0,
    fncg_fechamento: 0,
    fnct_id: 0,
    fngp_id: 0,
    fntp_id: 1
  },
  fntp_id: 1,
  fnis_id: 1,
  arrFngp: [],
  arrFncg: []
};
export const pageLista: IPageLista = {
  total: 0,
  fnct_id: 0,
  fntp_id: 1,
  fnit_date: moment().format("YYYY-MM-DD")
};

// FORM
export const formFinancaItem: IFNIT = {
  fnit_id: "new",
  fnit_value: 0,
  fnit_date: moment().format("YYYY-MM-DD"),
  fnit_obs: "",
  fnit_enable: 1,
  fnct_id: 0,
  fngp_id: 0,
  fncg_id: 0,
  fntp_id: 2,
  fnis_id: 1
};
export const formSearchExtrato: IformSearchExtrato = {
  r: "extrato",
  fntp_id: "",
  fngp_id: "",
  fncg_id: "",
  fnis_id: "",
  fnit_enable: 1,
  ...collectionInitial
};
export const formSearchFinancaCarteira: IformSearchCarteira = {
  fnct_enable: 1,
  fnct_panel: "",
  ...collectionInitial
};
export const formSearchFinancaGrupo: IformSearchGrupo = {
  fntp_id: 1,
  fngp_enable: 1,
  fngp_fechamento: "",
  fnct_id: "",
  ...collectionInitial
};
export const formSearchFinancaCategoria: IformSearchCategoria = {
  fncg_enable: 1,
  fncg_fechamento: "",
  fngp_id: "",
  fnct_id: "",
  fntp_id: 1,
  ...collectionInitial
};
export const formSearchFinancaAnaliseGrupoCategoria: IformSearchAnaliseGrupoCategoria = {
  fntp_id: 2,
  fngp_id: 0,
  fncg_id: 0
};

export const formSearchFinancaAnaliseAno: IformSearchAnaliseAno = {
  fntp_id: 2,
  fngp_id: 0,
  fncg_id: 0
};
