import React, { useCallback, useContext } from 'react'
import { FaCheckCircle } from 'react-icons/fa'
import { GlobalContext } from '../GlobalContext'
import useFetch from '../hooks/useFetch'

function ColetaStatus({ coleta, getColeta, getColetaProduto }) {
  const { user, setAlert } = useContext(GlobalContext)
  const { loading, request } = useFetch()

  const handleStatusColeta = useCallback(async (cols_event, endpoint) => {
    if ((coleta.cols_id + 1) == cols_event) {

      const body = {
        motr_id: user.usua_id,
        finc_id: user.usua_id,
      }

      const { status, message } = await request('post', `coleta/${coleta.cole_id}/${endpoint}`, body)

      if (status == 200) {
        setAlert({
          type: 'success',
          label: message
        })
        getColeta()
        getColetaProduto()
      }
    }
  }, [request, coleta, user])

  // --

  let iconFaCheckCircle = []
  let itemPointer = []
  let itemOpacity = []
  Array(1, 2, 3, 4, 5).map((el, i) => {
    iconFaCheckCircle[i] = ''
    itemPointer[i] = ''
    itemOpacity[i] = {}

    if (el <= coleta.cols_id) {
      iconFaCheckCircle[i] = 'icon-success'
    }
    if (el > (coleta.cols_id + 1)) {
      itemOpacity[i] = { opacity: '0.25' }
    }
    if (el == (coleta.cols_id + 1)) {
      iconFaCheckCircle[i] = 'icon-orange'
      itemPointer[i] = 'cursor-pointer'
    }
  })

  return (
    <section className="mb-3">
      <h4 className="p-0 mb-3 col-12 border-bottom border-dark">Status de coleta:</h4>

      {user.usut_id != 3 &&
        <ul className="list-group list-group-flush mb-3">
          <li className={`list-group-item py-1 d-flex align-items-center ${itemPointer[0]} `} style={itemOpacity[0]}>
            <div className={`d-flex align-items-center ${iconFaCheckCircle[0]}`}><FaCheckCircle /></div>
            <span className="ml-2">Coleta solicitada</span>
          </li>
          <li className={`list-group-item py-1 d-flex align-items-center ${itemPointer[1]} `} style={itemOpacity[1]} onClick={() => handleStatusColeta(2, 'accept')}>
            <div className={`d-flex align-items-center ${iconFaCheckCircle[1]}`}><FaCheckCircle /></div>
            <span className="ml-2">Coleta em andamento</span>
          </li>
          <li className={`list-group-item py-1 d-flex align-items-center ${itemPointer[2]} `} style={itemOpacity[2]} onClick={() => handleStatusColeta(3, 'deliver')}>
            <div className={`d-flex align-items-center ${iconFaCheckCircle[2]}`}><FaCheckCircle /></div>
            <span className="ml-2">Coleta realizada</span>
          </li>
          <li className={`list-group-item py-1 d-flex align-items-center ${itemPointer[3]} `} style={itemOpacity[3]} onClick={() => handleStatusColeta(4, 'delivered')}>
            <div className={`d-flex align-items-center ${iconFaCheckCircle[3]}`}><FaCheckCircle /></div>
            <span className="ml-2">Coleta entregue</span>
          </li>

          {user.usut_id == 1 &&
            <li className={`list-group-item py-1 d-flex align-items-center ${itemPointer[4]} `} style={itemOpacity[4]} onClick={() => handleStatusColeta(5, 'completed')}>
              <div className={`d-flex align-items-center ${iconFaCheckCircle[4]}`}><FaCheckCircle /></div>
              <span className="ml-2">Coleta concluida</span>
            </li>}
        </ul>
      }
      {coleta &&
        <ul className="list-group">
          {coleta.colh.map(item => (
            <li className="list-group-item" key={`status-historico-${item.colh_id}`} >
              {item.colh_date} | {item.cols.cols_name} {item.cols_id > 1 ? ` | ${item.usua.usua_name}` : ''}
            </li>
          ))}
        </ul>}
    </section>
  )
}

export default ColetaStatus
