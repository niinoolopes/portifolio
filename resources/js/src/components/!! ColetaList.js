import React, { memo, useEffect, useCallback, useState } from 'react'
import ColetaTabela from './ColetaTabela'
import useFetch from '../hooks/useFetch'
import ColetaModal from './ColetaModal'

function ColetaList() {
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
    console.log(data)

    if (status == 200) {
      data.map(el => {
        if (el.cols_id == 1) setNews((arr) => [...arr, el])
        if (el.cols_id == 2) setAccept((arr) => [...arr, el])
        if (el.cols_id == 3) setDeliver((arr) => [...arr, el])
        if (el.cols_id == 4) setDelivered((arr) => [...arr, el])
        if (el.cols_id == 5) setCompleted((arr) => [...arr, el])
      })
    }

  }, [request, watchColeta])

  
  if (loading) return null

  return (
    <div>
      <p>1 {watchColeta} 2</p>

      <ColetaTabela title="Coleta solicitada" data={news || []} setModalColeta={setModalColeta} setWatchColeta={setWatchColeta} />

      {accept.length > 0 &&
        <ColetaTabela title="Coleta aceita para retirada" data={accept} setModalColeta={setModalColeta} setWatchColeta={setWatchColeta} />}

      {deliver.length > 0 &&
        <ColetaTabela title="Coleta realizada" data={deliver} setModalColeta={setModalColeta} setWatchColeta={setWatchColeta} />}

      {delivered.length > 0 &&
        <ColetaTabela title="Coleta entregue" data={delivered} setModalColeta={setModalColeta} setWatchColeta={setWatchColeta} />}

      {completed.length > 0 &&
        <ColetaTabela title="Coleta concluida" data={completed} setModalColeta={setModalColeta} setWatchColeta={setWatchColeta} />}


      { modalColeta &&
        <ColetaModal modalColeta={modalColeta} setModalColeta={setModalColeta} />
      }
    </div>
  )
}

export default memo(ColetaList)
