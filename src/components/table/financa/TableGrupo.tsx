import { FaEdit } from "react-icons/fa"
import useNavigate from "../../../hooks/useNavigate"
import { ITableGrupoProps, IFNGP } from '../../../types/financa'

export default function TableGrupo(props: ITableGrupoProps) {
  const { urlNavigate } = useNavigate()

  return (
    <section className="container-table">
      <table className="table table-sm">
        <thead>
          <tr>
            <th className="text-center" style={{ width: '30px' }}>#</th>
            <th className="text-center" style={{ width: '40px' }}></th>
            <th className="">Carteira</th>
            <th className="">Tipo</th>
            <th className="">Descrição</th>
            <th className="text-center">Status</th>
            <th className="text-center">Fechamento</th>
          </tr>
        </thead>
        <tbody>
          {props?.items &&
            props?.items.map((item: IFNGP) => (
              <tr key={`td-fngp-${item.fngp_id}`}>
                <td className="td-id">{item.fngp_id}</td>
                <td>
                  <div
                    className="td-icons"
                    onClick={() => urlNavigate(`/configuracao/financa/grupo/adm/${item.fngp_id}`)}
                  >
                    <span className="cursor-pointer">
                      <FaEdit />
                    </span>
                  </div>
                </td>
                <td className="td-100">{item.fnct?.fnct_description}</td>
                <td className="td-100">{item.fntp?.fntp_description}</td>
                <td className="">{item.fngp_description}</td>
                <td className="text-center td-100">{item.fngp_enable ? 'Ativo' : 'Inativo'}</td>
                <td className="text-center td-100">{item.fngp_fechamento ? 'Sim' : '-'}</td>
              </tr>
            ))}
        </tbody>
      </table>
    </section>
  )
}
