type IOptionsProps = {
  style?: "currency" | "decimal" | "percent";
  currencyDisplay?: "symbol" | "code" | "name";
};
function parseCurrency(value: number, options: IOptionsProps = {}) {
  return Number(value).toLocaleString("pt-br", {
    style: "currency",
    currency: "BRL",
    minimumFractionDigits: 2,
    ...options
  });
}

export default parseCurrency;
