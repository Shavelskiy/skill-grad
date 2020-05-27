import React from 'react';
import css from './inputs.scss';

export function TextInput({label, value, setValue}) {
  return (
    <div className="input">
      <label>{label}</label>
      <input
        type="text"
        value={value}
        onChange={(event) => setValue(event.target.value)}
      />
    </div>
  );
}

export function NumberInput({label, value, setValue}) {
  return (
    <div className="input">
      <label>{label}</label>
      <input
        type="number"
        value={value}
        onChange={(event) => setValue(event.target.value)}
      />
    </div>
  );
}

export function SaveButton({handler}) {
  return (
    <div className="save-btn">
      <button
        className="btn success"
        onClick={() => handler()}
      >
        Сохранить
      </button>
    </div>
  );
}
