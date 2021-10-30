import { ITableAnaliseGrupoCategoria } from '../../../types/financa'

export default function TableAnaliseGrupoCategoria(props: ITableAnaliseGrupoCategoria) {
  return (
    <section className="container-table">
      <table className="table table-sm">
        <thead>
          <tr>
            <th className="text-center">Mês</th>
            <th className="text-center">Valor</th>
          </tr>
        </thead>
        <tbody>
          {props?.items &&
            props?.items.map((item, i: number) => (
              <tr key={`${i}-${item.name}`}>
                <td className="text-left">{item.name}</td>
                <td className="text-end">{item.value}</td>
              </tr>
            ))}
        </tbody>
      </table>
    </section>
  )
}
