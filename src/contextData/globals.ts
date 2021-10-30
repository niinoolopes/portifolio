import {
  IAccordion,
  IAside,
  ICollection,
  IGraficoBase,
  IPageDashboard,
  IPaginationLinks
} from "../types/global";

// GERAL
export const collectionInitial: ICollection = {
  total: 0,
  page: 1,
  per_page: 15,
  to: 0,
  from: 0,
  last_page: 0
};
export const dataCollectionInitial = {
  items: [],
  pagination: collectionInitial
};
export const pagination: IPaginationLinks = {
  links: []
  // btnPreview: false,
  // btnNext: false
};
export const dataAsideInitial: IAside = {
  menu: false,
  inputPeriodo: false,
  inputFinanca: false,
  inputCofre: false,
  inputInvestimento: false
};
export const dataAccordionInitial: IAccordion = {
  menu: false,
  inputPeriodo: false,
  inputFinanca: false,
  inputCofre: false,
  inputInvestimento: false
};

// GRAFICO
export const GraficoBar: IGraficoBase = {
  label: [],
  value: []
};
export const GraficoPie: IGraficoBase = {
  label: ["", "", "", ""],
  value: [1, 1, 1, 1]
};
// PAGE
export const pageDashboardInitial: IPageDashboard = {
  financa: {
    saldo: {
      receita: 0,
      despesa: 0,
      sobra: 0,
      estimado: 0
    },
    saldoPie: GraficoBar,
    fntpPie: GraficoBar,
    fngpReceitaPie: GraficoBar,
    fngpDespesaPie: GraficoBar
  }
};
