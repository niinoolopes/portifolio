import { FaEdit } from 'react-icons/fa';
import useNavigate from "../../../hooks/useNavigate";
import { ITableCarteiraProps, IFNCT } from '../../../types/financa'

export default function TableCarteira(props: ITableCarteiraProps) {
  const { urlNavigate } = useNavigate()

  return (
    <section className="container-table">
      <table className="table table-sm">
        <thead>
          <tr>
            <th className="text-center" style={{ width: '30px' }}>#</th>
            <th className="text-center" style={{ width: '40px' }}></th>
            <th className="">Descrição</th>
            <th className="text-center">Status</th>
            <th className="text-center">Painel</th>
          </tr>
        </thead>
        <tbody>
          {props?.items &&
            props?.items.map((item: IFNCT) => (
              <tr key={item.fnct_id}>
                <td className="text-center td-id">{item.fnct_id}</td>
                <td>
                  <div
                    className="td-icons"
                    onClick={() => urlNavigate(`/configuracao/financa/carteira/adm/${item.fnct_id}`)}
                  >
                    <span className="cursor-pointer">
                      <FaEdit />
                    </span>
                  </div>
                </td>
                <td className="">{item.fnct_description}</td>
                <td className="text-center td-100">{item.fnct_enable ? 'Ativo' : 'Inativo'}</td>
                <td className="text-center td-100">{item.fnct_panel ? 'Em uso' : '-'}</td>
              </tr>
            ))}
        </tbody>
      </table>
    </section>
  )
}
