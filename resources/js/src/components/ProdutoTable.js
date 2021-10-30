import React, { memo, useContext } from 'react'
import { FaEdit, FaPlus, FaTrash } from 'react-icons/fa'
import { GlobalContext } from '../GlobalContext'

function ProdutoTable({ coleta, coletaProduto, admFormColetaProdutoType, removeColetaProduto }) {
  const { user } = useContext(GlobalContext)
  return (
    <section className="mb-3">
      <h4 className="p-0 mb-2 col-12 border-bottom border-dark d-flex align-items-center justify-content-between">
        <span>Produtos:</span>
        <button type="button" className='inline-d-flex align-items-center justify-content-center bg-transparent border-0 text-secondary m-0 mb-2' onClick={() => admFormColetaProdutoType()}><FaPlus size="17px" /></button>
      </h4>

      <table className="table table-sm table-hover">
        <thead>
          <tr>
            {(coleta.cols_id <= 2 || (coleta.cole_id <= 4 && user.usut_id == 1)) &&
              <th width="80px"></th>}
            <th className="py-0 text-center">Tipo de produto</th>
            <th className="py-0 text-center">Descrição</th>
            <th className="py-0 text-center d-none d-md-table-cell">Quantidade</th>
            <th className="py-0 text-center d-none d-md-table-cell">Preço uni.</th>
            <th className="py-0 text-center d-none d-md-table-cell">Preço</th>
          </tr>
        </thead>
        <tbody>
          {coletaProduto.map(p => (
            <tr key={`coleta-produtos-${p.colp_id}`}>
              { (coleta.cols_id <= 2 || (coleta.cole_id <= 4 && user.usut_id == 1)) &&
                <td>
                  <div className="d-flex justify-content-start">
                    <div className="cursor-pointer inline-d-flex" onClick={() => admFormColetaProdutoType(p.colp_id)}><FaEdit /></div>
                    <div className="cursor-pointer inline-d-flex ml-3" onClick={() => removeColetaProduto(p.colp_id)}><FaTrash size="18px" /></div>
                  </div>
                </td>}
              <td className="text-center">{p.copt ? p.copt.copt_type : ''}</td>
              <td className="text-center">{p.colp_description}</td>
              <td className="text-center">{p.colp_quantity}</td>
              <td className="text-center">{p.colp_price_unit}</td>
              <td className="text-center">{p.colp_price}</td>
            </tr>
          ))}
        </tbody>
      </table>
    </section>
  )
}

export default memo(ProdutoTable)
