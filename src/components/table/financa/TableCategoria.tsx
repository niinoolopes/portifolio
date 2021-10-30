import { FaEdit } from "react-icons/fa"
import useNavigate from "../../../hooks/useNavigate"
import { IFNCG, ITableCategoriaProps } from "../../../types/financa"

export default function TableCategoria(props: ITableCategoriaProps) {
  const { urlNavigate } = useNavigate()

  return (
    <section className="container-table">
      <table className="table table-sm">
        <thead>
          <tr>
            <th className="text-center" style={{ width: '30px' }}>#</th>
            <th className="text-center" style={{ width: '40px' }}></th>
            <th className="">Tipo</th>
            <th className="">Descrição</th>
            <th className="text-center">Status</th>
            <th className="text-center">Fechamento</th>
          </tr>
        </thead>
        <tbody>
          {props?.items &&
            props?.items.map((item: IFNCG) => (
              <tr key={`td-fngp-${item.fncg_id}`}>
                <td className="text-center td-id">{item.fncg_id}</td>
                <td>
                  <div
                    className="td-icons"
                    onClick={() => urlNavigate(`/configuracao/financa/categoria/adm/${item.fncg_id}`)}
                  >
                    <span className="cursor-pointer">
                      <FaEdit />
                    </span>
                  </div>
                </td>
                <td className="td-100">{item.fngp?.fngp_description}</td>
                <td className="">{item.fncg_description}</td>
                <td className="text-center td-100">{item.fncg_enable ? 'Ativo' : 'Inativo'}</td>
                <td className="text-center td-100">{item.fncg_fechamento ? 'Sim' : '-'}</td>
              </tr>
            ))}
        </tbody>
      </table>
    </section>
  )
}
