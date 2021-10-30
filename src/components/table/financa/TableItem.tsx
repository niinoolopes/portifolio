import React from 'react'
import { FaEdit } from 'react-icons/fa';
import useNavigate from "../../../hooks/useNavigate";
import { ITableItemProps, IFNIT } from '../../../types/financa'

export default function TableItem(props: ITableItemProps) {
  const { urlNavigate } = useNavigate()

  return (
    <section className="container-table">

      <table className="table table-sm">
        <thead>
          <tr>
            {/* <th className="text-center" style={{ width: '30px' }}>#</th> */}
            <th className="text-center" style={{ width: '40px' }}></th>
            <th className="text-start">Tipo</th>
            <th className="text-start">Grupo</th>
            <th className="text-start">Categoria</th>
            <th className="text-center">Situação</th>
            <th className="text-center">Valor</th>
            <th className="text-center">Data</th>
            <th className="text-center">Status</th>
          </tr>
        </thead>
        <tbody>
          {props?.items &&
            props?.items.map((item: IFNIT) => (
              <tr
                key={item.fnit_id}
                className={`${item.fnit_enable === 1 ? '' : 'text-black-50'}`}
              >
                {/* <td className="td-id">
                  <small>{item.fnit_id}</small>
                </td> */}
                <td>
                  <div
                    className="td-icons"
                    onClick={() => urlNavigate(`/financa/item/${item.fnit_id}?from=${props.from}`)}
                  >
                    <span className="cursor-pointer">
                      <FaEdit />
                    </span>
                  </div>
                </td>
                <td className="small text-start cursor-pointer td-link td-finc"
                  onClick={() => urlNavigate(`/financa/analise/grupo-categoria?fntp_id=${item.fntp_id}`)}
                >
                  {item.fntp?.fntp_description}
                </td>
                <td
                  className="small text-start cursor-pointer td-link td-finc"
                  onClick={() => urlNavigate(`/financa/analise/grupo-categoria?fntp_id=${item.fntp_id}&fngp_id=${item.fngp_id}`)}
                >
                  {item.fngp?.fngp_description}
                </td>
                <td
                  className="small text-start cursor-pointer td-link td-finc"
                  onClick={() => urlNavigate(`/financa/analise/grupo-categoria?fntp_id=${item.fntp_id}&fngp_id=${item.fngp_id}&fncg_id=${item.fncg_id}`)}
                >
                  {item.fncg?.fncg_description}
                </td>
                <td className="small text-start ">
                  <span className={`d-block td-finc td-finc-${String(item.fnis?.fnis_description).toLocaleLowerCase()}`}>
                    {item.fnis?.fnis_description}
                  </span>
                </td>
                <td className="small text-center td-finc">
                  {item.fnit_value}
                </td>
                <td className="small text-center td-finc">
                  {item.fnit_date}
                </td>
                <td className="small td-finc">
                  <span className="td-finc-obs text-truncate">
                    {item.fnit_obs}
                  </span>
                </td>
              </tr>
            ))}
        </tbody>
      </table>
    </section>
  )
}