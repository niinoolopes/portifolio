import { useState } from 'react'
import { IAccordionProps } from '../../types/global'

export default function Accordion(props: IAccordionProps) {
  const [status, setStatus] = useState(false)

  return (
    <div className="accordion">
      <div className="accordion-item">
        <h2 className="accordion-header" id="headingOne">
          <button
            onClick={() => setStatus(!status)}
            className={`accordion-button text-dark bg-light ${status ? '' : 'collapsed'}`}
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapseOne"
            aria-controls="collapseOne"
            aria-expanded="false"
          >
            {props.title.toLocaleUpperCase()}
          </button>
        </h2>
        <div className={`collapse ${status ? 'show' : ''}`}>
          <div className="accordion-body">
            {props.children}
          </div>
        </div>
      </div>
    </div>
  )
}
