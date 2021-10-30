import { ICardValues } from '../../../types/financa'

export default function CardValues(props: ICardValues) {
  return (
    <div className="row g-1 g-sm-2">
      <div className="col-6 col-lg-3 col-xxl-2">
        <div className="card p-2">
          <p className="fs-3 border-bottom m-0" style={{ fontSize: '28px' }}>Receita</p>
          <p className="d-flex align-items-end justify-content-between m-0">
            <span className="fs-5 small fw-light text-black-50 ps-sm-1 ps-md-2">R$</span>
            <span className="fs-2 fw-light text-muted pe-sm-1 pe-md-2">{props.isFetch ? '-' : props.values.receita}</span>
          </p>
        </div>
      </div>
      <div className="col-6 col-lg-3 col-xxl-2">
        <div className="card p-2">
          <p className="fs-3 border-bottom m-0" style={{ fontSize: '28px' }}>Despesa</p>
          <p className="d-flex align-items-end justify-content-between m-0">
            <span className="fs-5 small fw-light text-black-50 ps-sm-1 ps-md-2">R$</span>
            <span className="fs-2 fw-light text-muted pe-sm-1 pe-md-2">{props.isFetch ? '-' : props.values.despesa}</span>
          </p>
        </div>
      </div>
      <div className="col-6 col-lg-3 col-xxl-2">
        <div className="card p-2">
          <p className="fs-3 border-bottom m-0" style={{ fontSize: '28px' }}>Sobra</p>
          <p className="d-flex align-items-end justify-content-between m-0">
            <span className="fs-5 small fw-light text-black-50 ps-sm-1 ps-md-2">R$</span>
            <span className="fs-2 fw-light text-muted pe-sm-1 pe-md-2">{props.isFetch ? '-' : props.values.sobra}</span>
          </p>
        </div>
      </div>
      <div className="col-6 col-lg-3 col-xxl-2">
        <div className="card p-2">
          <p className="fs-3 border-bottom m-0" style={{ fontSize: '28px' }}>Estimado</p>
          <p className="d-flex align-items-end justify-content-between m-0">
            <span className="fs-5 small fw-light text-black-50 ps-sm-1 ps-md-2">R$</span>
            <span className="fs-2 fw-light text-muted pe-sm-1 pe-md-2">{props.isFetch ? '-' : props.values.estimado}</span>
          </p>
        </div>
      </div>
    </div>
  )
}
