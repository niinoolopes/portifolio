type SelectProps = {
  label?: string
  name: string
  children: any
  defaultValue?: string
  value?: string
  disabled?: boolean
  register?: any
  options?: any
  error?: any
  onChange?: any
  cssInput?: string
  cssLabel?: string
}

export default function Select({ cssLabel, cssInput, label, name, register, options, error, children, ...others }: SelectProps) {

  const cssLabelBase = `form-label d-block small ${cssLabel || 'mb-1'}`
  const cssInputBase = `form-control form-control-sm shadow-none ${cssInput || ''}`

  if (register) {
    return (
      <>
        {label && <label htmlFor={name} className={`${cssLabelBase}`}>{label}</label>}
        <select id={name} className={`${cssInputBase} ${error ? 'border border-danger' : ''}`} {...register(name, options)} {...others}>
          {children}
        </select>
      </>
    )
  }

  return (
    <>
      {label && <label htmlFor={name} className={`${cssLabelBase}`}>{label}</label>}
      <select id={name} className={`${cssInputBase} ${error ? 'border border-danger' : ''}`} {...others}>
        {children}
      </select>
    </>
  )
}
