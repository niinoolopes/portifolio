type ContentTitleProps = {
  text: string
  btns?: any
}
export default function ContentTitle(props: ContentTitleProps) {

  const css = props.btns
    ? 'd-flex justify-content-between align-items-center'
    : ''

  return (
    <section className={`${css} mb-0 w-100`}>

      <h2 className="m-0 fs-2 fw-bold lh-sm">{props.text}</h2>

      {props.btns && (
        <div className="m-0 d-flex">
          {props.btns}
        </div>
      )}
    </section>
  )
}
