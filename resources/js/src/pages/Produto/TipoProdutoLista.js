import React, { memo, useContext, useEffect, useState } from 'react'
import { FaEdit, FaPlus } from 'react-icons/fa';
import { useNavigate } from 'react-router-dom';
import { GlobalContext } from '../../GlobalContext';
import useFetch from '../../hooks/useFetch';

function TipoProdutoLista() {
  const { baseUrl } = useContext(GlobalContext)
  const { loading, request } = useFetch()
  const navigate = useNavigate()

  const [produtoTypes, setProdutoTypes] = useState([])

  useEffect(async () => {
    const { status, data } = await request('get', `produto`)
    if (status == 200) {
      setProdutoTypes(data)
    }
  }, [request, setProdutoTypes])


  return (
    <div className="container py-3 px-2 p-md-4">
      <div className='card py-3 px-2 p-md-4 shadow-sm'>
        <h3 className="display-5 m-0 d-flex align-items-center justify-content-between">
          <span>Tipo de produto</span>
          <button type="button" className='inline-d-flex align-items-center justify-content-center bg-transparent border-0 text-secondary m-0 mb-2' onClick={() => navigate(`${baseUrl}usuario-novo`)}><FaPlus size="18px" /></button>
        </h3>
        <hr />

        <table className="table table-sm table-striped">
          <thead>
            <tr>
              <th className="border-top-0" width="40px"></th>
              <th className="border-top-0 text-center">Tipo</th>
              <th className="border-top-0 text-center">Preço</th>
              <th className="border-top-0 text-center">Status</th>
            </tr>
          </thead>
          <tbody>
            {produtoTypes.map(el => (
              <tr key={el.copt_id}>
                <td>
                  <div className="d-flex justify-content-center">
                    <div className="cursor-pointer inline-d-flex text-secondary" onClick={() => navigate(`${baseUrl}tipo-produto/${el.copt_id}`)}><FaEdit /></div>
                  </div>
                </td>
                <td className="text-center">{el.copt_type}</td>
                <td className="text-center">{el.copt_price}</td>
                <td className="text-center">{el.copt_status ? 'Ativo' : 'Inativo'}</td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>
    </div>
  )
}

export default memo(TipoProdutoLista)
