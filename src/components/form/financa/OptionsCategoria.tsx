import { IFNCG } from '../../../types/financa'

type OptionsCategoriaProps = {
  items: IFNCG[]
}

export default function OptionsCategoria(props: OptionsCategoriaProps) {
  return (
    <>
      <option value="">Selecione</option>
      {
        props.items.map((item: IFNCG) => (
          <option key={`op-fncg-${item.fncg_id}`} value={item.fncg_id}>
            {item.fncg_description}
          </option>
        ))
      }
    </>
  )
}
