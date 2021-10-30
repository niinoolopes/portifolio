type ContentSubtitleProps = {
  text: string
  btns?: any
}
export default function ContentSubtitle(props: ContentSubtitleProps) {

  const css = props.btns
    ? 'd-flex justify-content-between align-items-center'
    : ''

  return (
    <section className={`${css} mb-1 w-100`}>

      <h3 className="m-0 fs-3 fw-1 lh-sm fw-light text-capitalize">{props.text}</h3>

      {props.btns && (
        <div className="d-flex m-0">
          {props.btns}
        </div>
      )}

    </section>
  )
}
