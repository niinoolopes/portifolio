type InputProps = {
  label?: string
  name: string
  defaultValue?: string
  value?: string | number
  placeholder?: string
  type?: string
  step?: string
  disabled?: boolean
  register?: any
  options?: any
  error?: any
  onChange?: any
  cssInput?: string
  cssLabel?: string
}

export default function Input({ cssLabel, cssInput, label, name, register = null, options = {}, error = null, ...others }: InputProps) {

  const cssLabelBase = `form-label d-block small ${cssLabel || 'mb-1'}`
  const cssInputBase = `form-control form-control-sm shadow-none ${cssInput || ''}`

  if (register) {
    return (
      <>
        {label && <label htmlFor={name} className={`${cssLabelBase}`}>{label}</label>}
        <input id={name} className={`${cssInputBase} ${error ? 'border border-danger' : ''}`} {...register(name, options)}  {...others} />
      </>
    )
  }

  return (
    <>
      {label && <label htmlFor={name} className={`${cssLabelBase}`}>{label}</label>}
      <input id={name} className={cssInputBase}  {...others} />
    </>
  )
}

