import React, { useEffect, useCallback, useState } from 'react'
import ColetaTabela from '../../components/ColetaTabela'
import ColetaModal from '../../components/ColetaModal'
import useFetch from '../../hooks/useFetch'

export default function PainelCliente() {
  const { loading, request } = useFetch()
  const [modalColeta, setModalColeta] = useState(false)

  const [news, setNews] = useState([])
  const [accept, setAccept] = useState([])
  const [deliver, setDeliver] = useState([])
  const [delivered, setDelivered] = useState([])
  const [completed, setCompleted] = useState([])

  useEffect(async () => {
    const { status, data } = await request('get', 'coleta')
    if (status == 200) {
      data.map(el => {
        if (el.cols_id == 1) setNews((arr) => [...arr, el])
        if (el.cols_id == 2) setAccept((arr) => [...arr, el])
        if (el.cols_id == 3) setDeliver((arr) => [...arr, el])
        if (el.cols_id == 4) setDelivered((arr) => [...arr, el])
        if (el.cols_id == 5) setCompleted((arr) => [...arr, el])
      })
    }
  }, [request])

  const toggleModal = useCallback((event) => {
    if (event.target == event.currentTarget) {
      setModalColeta(false)
    }
  }, [])

  if (loading) return null

  return (
    <div className="container py-3 px-2 p-md-4">
      <ColetaTabela title="Coleta solicitada" data={news || []} setModalColeta={setModalColeta} />

      {accept.length > 0 &&
        <ColetaTabela title="Coleta aceita para retirada" data={accept} setModalColeta={setModalColeta} />}

      {deliver.length > 0 &&
        <ColetaTabela title="Coleta realizada" data={deliver} setModalColeta={setModalColeta} />}

      {delivered.length > 0 &&
        <ColetaTabela title="Coleta entregue" data={delivered} setModalColeta={setModalColeta} />}

      {completed.length > 0 &&
        <ColetaTabela title="Coleta concluida" data={completed} setModalColeta={setModalColeta} />}

      { modalColeta &&
        <ColetaModal modalColeta={modalColeta} toggleModal={toggleModal} setModalColeta={setModalColeta} />
      }
    </div>
  )
}
