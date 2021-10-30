import { useEffect, useRef } from "react"
import { useContextGlobal } from "../context/global"
import { IALERT } from "../types/global"

export default function Alert() {
  const { alert, setAlert } = useContextGlobal()
  const loopRef = useRef<any>(null)

  async function initial() {
    const timeInterval = alert.messages.length >= 3 ? 1000 : 1500

    loopRef.current && clearInterval(loopRef.current)

    loopRef.current = setInterval(() => {
      setAlert((data: IALERT) => {
        const oldMessages = data.messages

        const newMessages: string[] = oldMessages.filter((el, i) => i !== 0);
        const neewEnable = newMessages.length > 0

        // remove Interval quando for FALSE
        !neewEnable && clearInterval(loopRef.current)

        return {
          ...data,
          enable: neewEnable,
          messages: newMessages
        }
      });
    }, timeInterval)
  }

  function closeAlert() {
    clearInterval(loopRef.current)

    setAlert((data: IALERT) => {
      return {
        ...data,
        enable: false,
        messages: []
      }
    });
  }

  useEffect(() => {
    if (alert.enable) {
      initial()
    }
    /* eslint-disable-next-line react-hooks/exhaustive-deps */
  }, [alert])

  return (
    <section id="layout-alert" className={`position-absolute p-3 w-100 d-flex justify-content-center ${alert.enable ? '--show' : ''}`}>
      <div className={`alert alert-dismissible alert-${alert.type} col-12 col-md-8 mt-3 mt-lg-4 `}>
        <button type="button" className="btn-close" onClick={closeAlert}></button>

        <h4 className="alert-heading">Mensagem!</h4>

        <hr className="my-1" />

        <ul className="m-0">
          {alert.messages.map((msg: string, index: number) => (
            <li key={index} className="m-0">{msg}</li>
          ))}
        </ul>

      </div>
    </section>
  )
}
