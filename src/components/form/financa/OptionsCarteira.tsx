import { IFNCT } from '../../../types/financa'

type OptionsCarteiraProps = {
  items: IFNCT[]
  optionEmpty?: boolean
}

export default function OptionsCarteira(props: OptionsCarteiraProps) {
  return (
    <>
      {props.optionEmpty === undefined || props.optionEmpty === true
        ? <option value="">Selecione</option>
        : null
      }
      {props.items &&
        props.items.map((item: IFNCT) => (
          <option key={`op-fnct-${item.fnct_id}`} value={item.fnct_id}>
            {item.fnct_description}
          </option>
        ))
      }
    </>
  )
}
