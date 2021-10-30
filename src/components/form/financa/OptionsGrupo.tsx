import { IFNGP } from '../../../types/financa'

type OptionsGrupoProps = {
  items: IFNGP[]
}

export default function OptionsGrupo(props: OptionsGrupoProps) {
  return (
    <>
      <option value="">Selecione</option>
      {
        props.items.map((item: IFNGP) => (
          <option key={`op-fngp-${item.fngp_id}`} value={item.fngp_id}>
            {item.fngp_description}
          </option>
        ))
      }
    </>
  )
}
