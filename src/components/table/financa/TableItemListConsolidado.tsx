import { ITableItemListConsolidadoProps, IConsolidadoItemComputed } from '../../../types/financa'

export default function TableItemListConsolidado(props: ITableItemListConsolidadoProps) {

  return (
    <section className="container-table">
      <table className="table table-sm">
        <thead>
          <tr>
            <th className="text-left break-text">Origem</th>
            <th className="text-end">Total</th>
            <th className="text-end">Percentual</th>
            <th className="text-end">Pago</th>
            <th className="text-end">Pendente</th>
            <th className="text-end">Talvez</th>
          </tr>
        </thead>
        <tbody>
          {!!props?.items?.length
            ? (
              props?.items.map((item: IConsolidadoItemComputed, i: number) => (
                <tr key={`${i}-${item.name}`} >
                  <td className="small text-left break-text break-text">{item.name}</td>
                  <td className="small text-end">{item.total}</td>
                  <td className="small text-end">{Number(item.percentual).toFixed(2)}%</td>
                  <td className="small text-end">{item.pago}</td>
                  <td className="small text-end">{item.pendente}</td>
                  <td className="small text-end">{item.talvez}</td>
                </tr>
              ))
            )
            : (
              <tr>
                <td className="td-opacity" colSpan={6}>Não há registros</td>
              </tr>
            )
          }
        </tbody>
      </table>
    </section>
  )
}