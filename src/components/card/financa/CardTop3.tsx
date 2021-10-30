import React from 'react'
import { ITap3Pops } from '../../../types/financa'

export default function CardTop3(props: ITap3Pops) {
  return (
    <div className="d-flex align-items-end justify-content-between mb-1 p-1 border">
      <span className="fw-light text-muted text-truncate">{props.isFetch ? '-' : props.item.name}</span>
      <span className="small fw-muted">R$ {props.item.total}</span>
    </div>
  )
}
