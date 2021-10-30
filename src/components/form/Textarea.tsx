type TextareaProps = {
  label?: string
  name: string
  defaultValue?: string
  value?: string
  disabled?: boolean
  maxLength?: any
  register?: any
  options?: any
  error?: any
  onChange?: any
}

export default function Textarea({ label, name, register = null, options = {}, error = null, ...others }: TextareaProps) {

  const css = "form-control form-control-sm shadow-none"

  if (register) {
    return (
      <>
        {label && <label htmlFor={name} className="form-label d-block mb-1 small">{label}</label>}
        <textarea rows={4} id={name} className={`${css} ${error ? 'border border-danger' : ''}`} {...register(name, options)}  {...others} />
      </>
    )
  }

  return (
    <>
      {label && <label htmlFor={name} className="form-label d-block mb-1 small">{label}</label>}
      <textarea rows={4} id={name} className={css}  {...others} />
    </>
  )
}

