import { ITableAnaliseAno } from '../../../types/financa'
import parseCurrency from '../../../utils/parseCurrency'

export default function TableAnaliseAno(props: ITableAnaliseAno) {

  return (
    <section className="container-table">
      <table className="table table-sm">
        <thead>
          <tr>
            <th className="text-left break-text" style={{ maxWidth: '150px' }}>Origem</th>
            <th className="text-end" style={{ minWidth: '100px' }}>Total</th>
            <th className="text-end" style={{ minWidth: '100px' }}>Janeiro</th>
            <th className="text-end" style={{ minWidth: '100px' }}>Fevereiro</th>
            <th className="text-end" style={{ minWidth: '100px' }}>Março</th>
            <th className="text-end" style={{ minWidth: '100px' }}>Abril</th>
            <th className="text-end" style={{ minWidth: '100px' }}>Maio</th>
            <th className="text-end" style={{ minWidth: '100px' }}>Junho</th>
            <th className="text-end" style={{ minWidth: '100px' }}>Julho</th>
            <th className="text-end" style={{ minWidth: '100px' }}>Agosto</th>
            <th className="text-end" style={{ minWidth: '100px' }}>Setembro</th>
            <th className="text-end" style={{ minWidth: '100px' }}>Outubro</th>
            <th className="text-end" style={{ minWidth: '100px' }}>Novembro</th>
            <th className="text-end" style={{ minWidth: '100px' }}>Dezembro</th>
          </tr>
        </thead>
        <tbody>
          {props?.items &&
            props?.items.map((item, i) => (
              <tr key={`${i}-${item[0]}`}>
                {item.map((val: number | string, j: any) => {
                  return j === 0
                    ? (
                      <td
                        key={`${j}-${i}`}
                        style={{ maxWidth: '200px' }}
                        className="text-start break-text">
                        {val}
                      </td>
                    )
                    : (
                      <td className={`text-end small ${val === 0 ? 'td-opacity' : ''}`} key={`${j}-${i}`}>
                        {parseCurrency(Number(val))}
                      </td>
                    )
                })}
              </tr>
            ))}
        </tbody>
      </table>
    </section>
  )
}
