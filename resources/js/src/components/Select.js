import React, { memo } from 'react'

const Select = ({ error, label, name, value, onChange, children, disabled }) => {
  return (
    <div className="form-group">
      {
        label &&
        <label className="mb-0 small" htmlFor={name}>{label}</label>
      }
      <select
        className="form-control form-control-sm"
        id={name}
        name={name}
        value={value}
        onChange={onChange}
        disabled={disabled}
      >
        {children}
      </select>
      {
        error &&
        <span className="text-danger">{error}</span>
      }
    </div>
  )
}

export default memo(Select)