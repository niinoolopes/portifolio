import React, { memo } from 'react'

const Checkbox = ({ name, value, onChange, disabled }) => {

  return (
    <div className="form-check">
      <input
        type="checkbox"
        value={value}
        defaultChecked={value}
        className="form-check-input"
        onClick={onChange}
        disabled={disabled}
        id={name}
      />
      <label htmlFor={name} className="form-check-label">Status {value ? 'ativo' : 'inativo'}</label>
    </div>
  )
}

export default memo(Checkbox)