import { useContextFinanca } from "../../../context/financa"
import { IFNTP } from "../../../types/financa"

export default function OptionsTipo() {
  const { getTipo } = useContextFinanca()

  return (
    <>
      <option value="">Selecione</option>
      {
        getTipo.map((item: IFNTP) => (
          <option key={`op-fntp-${item.fntp_id}`} value={item.fntp_id}>
            {item.fntp_description}
          </option>
        ))
      }
    </>
  )
}
