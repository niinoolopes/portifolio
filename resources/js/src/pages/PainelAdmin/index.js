import React, { useEffect, useCallback, useState } from 'react'
import ColetaTabela from '../../components/ColetaTabela'
import ColetaModal from '../../components/ColetaModal'
import useFetch from '../../hooks/useFetch'

export default function PainelAdmin() {
  const { loading, request } = useFetch()
  const [modalColeta, setModalColeta] = useState(false)

  const [watchColeta, setWatchColeta] = useState(0)
  const [news, setNews] = useState([])
  const [accept, setAccept] = useState([])
  const [deliver, setDeliver] = useState([])
  const [delivered, setDelivered] = useState([])
  const [completed, setCompleted] = useState([])

  useEffect(async () => {
    const { status, data } = await request('get', 'coleta')
    if (status == 200) {

      setNews([])
      setAccept([])
      setDeliver([])
      setDelivered([])
      setCompleted([])

      data.map(el => {
        if (el.cols_id == 1) setNews((arr) => [...arr, el])
        if (el.cols_id == 2) setAccept((arr) => [...arr, el])
        if (el.cols_id == 3) setDeliver((arr) => [...arr, el])
        if (el.cols_id == 4) setDelivered((arr) => [...arr, el])
        if (el.cols_id == 5) setCompleted((arr) => [...arr, el])
      })
    }
  }, [request, watchColeta])

  const toggleModal = useCallback((event) => {
    if (event.target == event.currentTarget) {
      setModalColeta(false)
    }
  }, [])


  if (loading) return null

  return (
    <div className="container py-3 px-2 p-md-4">

      <div className="d-flex flex-wrap6 align-items-stretch overflow-auto mb-3">
        {[
          [news, 'Coletas novas'],
          [accept, 'Coletas em retiradas'],
          [deliver, 'Coletas realizadas'],
          [delivered, 'Coletas entregues'],
          [completed, 'Coletas concluídas'],
        ].map(([data, text], i) => (
          <div key={`card-${i}`} className="col-6 col-sm-4 col-lg mb-2 p-2">
            <div className="card h-100 text-center">
              <p className="mt-3 m-0 h2">{data.length}</p>
              <hr className="my-1 mx-3" />
              <p className="mb-2 lead">{text}</p>
            </div>
          </div>
        ))}
      </div>


      <ColetaTabela title="Coleta solicitada" data={news || []} setModalColeta={setModalColeta} watchColeta={watchColeta} setWatchColeta={setWatchColeta} />

      { accept.length > 0 &&
        <ColetaTabela title="Coleta aceita para retirada" data={accept} setModalColeta={setModalColeta} watchColeta={watchColeta} setWatchColeta={setWatchColeta} />}

      { deliver.length > 0 &&
        <ColetaTabela title="Coleta realizada" data={deliver} setModalColeta={setModalColeta} watchColeta={watchColeta} setWatchColeta={setWatchColeta} />}

      { delivered.length > 0 &&
        <ColetaTabela title="Coleta entregue" data={delivered} setModalColeta={setModalColeta} watchColeta={watchColeta} setWatchColeta={setWatchColeta} />}

      { completed.length > 0 &&
        <ColetaTabela title="Coleta concluida" data={completed} setModalColeta={setModalColeta} watchColeta={watchColeta} setWatchColeta={setWatchColeta} />}

      { modalColeta &&
        <ColetaModal modalColeta={modalColeta} toggleModal={toggleModal} setModalColeta={setModalColeta} />}
    </div >
  )
}
