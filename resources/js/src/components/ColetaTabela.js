import React, { useCallback, useContext } from 'react'
import { useNavigate } from 'react-router-dom';
import { GlobalContext } from '../GlobalContext'
import { FaCheckCircle, FaEdit, FaSearch, FaTimesCircle } from 'react-icons/fa'
import useDateFormat from '../helper/useDateFormat'
import useFetch from '../hooks/useFetch';

function ColetaTabela({ title, data, setModalColeta, setWatchColeta }) {
  const { user, baseUrl } = useContext(GlobalContext)
  const { loading, request } = useFetch()
  const navigate = useNavigate()

  const acceptColeta = useCallback(async (cole_id) => {
    const resAccept = await request('post', `coleta/${cole_id}/accept`, { motr_id: user.usua_id })
    console.log(resAccept)
    setWatchColeta(n => n + 1)
  }, [request, setWatchColeta])


  return (
    <div className="card py-3 px-2 p-md-4 mb-2">
      <h4 className="p-0 mb-1 col-12 border-bottom-secondary border-dark">{title}</h4>
      <div className="container-table">
        <table className="table table-sm table-hover">
          <thead>
            <tr>
              {/* <th width="80px"></th> */}
              <th className="border-top-0" width="80px"></th>
              <th className="py-0 text-center border-top-0">Data</th>
              <th className="py-0 text-center border-top-0 d-none d-md-table-cell">Status</th>
              <th className="py-0 text-center border-top-0 d-none d-md-table-cell">Motorista</th>
              <th className="py-0 text-center border-top-0">Cidade</th>
              <th className="py-0 text-center border-top-0">Bairro</th>
              <th className="py-0 text-center border-top-0">Endereço</th>
              <th className="py-0 text-center border-top-0">Número</th>
              <th className="py-0 text-center border-top-0">CEP</th>
            </tr>
          </thead>
          <tbody>
            {
              data.map(coleta => (
                <tr key={coleta.cole_id}>
                  <td>
                    <div className="d-flex justify-content-start">
                      {user.usut_id == 2 && coleta.cols_id == 1 &&
                        <div className="cursor-pointer inline-d-flex icon-success" onClick={() => acceptColeta(coleta.cole_id)}><FaCheckCircle /></div>}

                      {(user.usut_id != 2 || coleta.motr) &&
                        <div className="cursor-pointer inline-d-flex text-secondary" onClick={() => navigate(`${baseUrl}coleta/${coleta.cole_id}`)}><FaEdit /></div>}

                      <div className="cursor-pointer inline-d-flex ml-3" onClick={() => setModalColeta(coleta)}><FaSearch size="16px" /></div>
                    </div>
                  </td>
                  <td className="text-center">{useDateFormat(coleta.cole_date, ['DD', 'MM', 'YYYY'], ['/', '/'])}</td>
                  <td className="text-center d-none d-md-table-cell">{coleta.cols ? coleta.cols.cols_name : ''}</td>
                  <td className="text-center d-none d-md-table-cell">{coleta.motr ? coleta.motr.usua_name : '...'}</td>
                  <td className="text-center">{coleta.end ? coleta.end.end_city : ''}</td>
                  <td className="text-center">{coleta.end ? coleta.end.end_district : ''}</td>
                  <td className="text-center">{coleta.end ? coleta.end.end_address : ''}</td>
                  <td className="text-center">{coleta.end ? coleta.end.end_number : ''}</td>
                  <td className="text-center">{coleta.end ? coleta.end.end_zipcode : ''}</td>
                </tr>
              ))
            }
          </tbody>
        </table>
      </div>
    </div>
  )
}

export default ColetaTabela
