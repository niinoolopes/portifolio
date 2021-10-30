import { useContextFinanca } from "../../../context/financa"
import { IFNIS } from "../../../types/financa"

export default function OptionsSituacao() {
  const { getSituacao } = useContextFinanca()

  return (
    <>
      <option value="">Selecione</option>
      {
        getSituacao.map((item: IFNIS) => (
          <option key={`op-fnis-${item.fnis_id}`} value={item.fnis_id}>
            {item.fnis_description}
          </option>
        ))
      }
    </>
  )
}
