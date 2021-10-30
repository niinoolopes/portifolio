import React, { useCallback, useContext, useEffect } from 'react'
import { useNavigate } from 'react-router'
import { FaEdit, FaTimes } from 'react-icons/fa'
import { GlobalContext } from '../GlobalContext'
import Input from './Input'

function ColetaModal({ modalColeta, setModalColeta }) {
  const { baseUrl } = useContext(GlobalContext)
  const navigate = useNavigate()

  useEffect(() => {
    console.log(modalColeta)
  }, [modalColeta])

  const toggleModal = useCallback((event) => {
    if (event.target == event.currentTarget) {
      setModalColeta(false)
    }
  }, [setModalColeta])

  return (
    <div className={`modal fade area-modal ${modalColeta ? 'show d-block' : ''}`} onClick={toggleModal}>
      <div className="modal-dialog modal-lg" role="document">
        <div className="modal-content">
          <div className="modal-body">

            <h5 className="p-0 mb-2 col-12 border-bottom border-dark">Endereço de coleta:</h5>
            <div className="d-flex flex-wrap">
              <div className="px-2 col-12 col-md-6">
                <Input label="Endereço" type="text" name="end_address" value={modalColeta.end.end_address} disabled={1} />
              </div>
              <div className="px-2 col-4 col-md-2">
                <Input label="Número" type="number" name="end_number" value={modalColeta.end.end_number} disabled={1} />
              </div>
              <div className="px-2 col-8 col-md-4">
                <Input label="Complemento" type="text" name="end_complement" value={modalColeta.end.end_complement} disabled={1} />
              </div>
              <div className="px-2 col-5 col-md-3">
                <Input label="Cidade" type="text" name="end_city" value={modalColeta.end.end_city} disabled={1} />
              </div>
              <div className="px-2 col-7 col-md-3">
                <Input label="Bairro" type="text" name="end_district" value={modalColeta.end.end_district} disabled={1} />
              </div>
              <div className="px-2 col-3 col-md-3">
                <Input label="CEP" type="text" name="end_zipcode" value={modalColeta.end.end_zipcode} disabled={1} />
              </div>
              <div className="px-2 col-12 col-md-4 d-none d-md-block"></div>
            </div>

            <h5 className="p-0 my-2 col-12 border-bottom border-dark">Status da Coleta:</h5>
            <ul className="list-group">
              {
                modalColeta.colh.map(item => (
                  <li
                    className="list-group-item"
                    key={item.colh_id}
                  >
                    {item.colh_date} | {item.cols.cols_name} {item.cols_id > 1 ? ` | ${item.usua.usua_name}` : ''}
                  </li>
                ))
              }
            </ul>
          </div>

          <div className="modal-footer py-2 px-3">
            <button className="inline-d-flex align-items-center justify-content-center bg-transparent border border-secondary rounded text-muted py-1 px-2 m-0 mr-2" onClick={() => navigate(`${baseUrl}coleta/${modalColeta.cole_id}`)}><FaEdit size="18px" /></button>
            <button className="inline-d-flex align-items-center justify-content-center bg-secondary border-0 border-secondary rounded text-white py-1 px-2 m-0" onClick={() => setModalColeta(false)}><FaTimes size="18px" /></button>
          </div>

        </div>
      </div>
    </div>
  )
}

export default ColetaModal
