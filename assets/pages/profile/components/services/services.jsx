import React from 'react'

import css from './services.scss'


const Services = () => {
  return (
    <>
      <div className="container-0">
        <div className="col-lg-12 col-sm-4 col-md-12">
          <div className="balance">
            <h4>Текущий остаток: <strong>1837,00 руб.</strong></h4>
            <button className="open-pay-balance button-blue">Пополнить баланс</button>
          </div>
        </div>
        <div className="col-lg-12 no-gutter">
          <table className="table document">
            <thead>
            <tr>
              <th>Дата</th>
              <th>Услуга</th>
              <th>Итого с НДС (руб.)</th>
              <th>Номер счет-фактуры</th>
              <th>Документы</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <td>
                <span className="date">12.02.2020</span>
              </td>
              <td className="title">Продвижение программы: «Базовые уроки флористики»</td>
              <td>
                <div className="price">990.00</div>
              </td>
              <td className="number">8546972-6347895/GH-1</td>
              <td><a className="link-icon" href="#">
                <span className="icon pdf"></span>
                Счет-фактура
              </a></td>
              <td><a className="link-icon" href="#">
                <span className="icon pdf"></span>Акт</a></td>
            </tr>
            <tr>
              <td>
                <span className="date">12.02.2020</span>
              </td>
              <td className="title">Продвижение программы: «Базовые уроки флористики»</td>
              <td>
                <div className="price">990.00</div>
              </td>
              <td className="number">8546972-6347895/GH-1</td>
              <td><a className="link-icon" href="#">
                <span className="icon pdf"></span>
                Счет-фактура
              </a></td>
              <td><a className="link-icon" href="#">
                <span className="icon pdf"></span>Акт</a></td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div className="pagination mt-20">
        <a href="#">
          <span className="prev"></span>
        </a>
        <a href="#">1</a>
        <a className="active" href="#">2</a>
        <a href="#">3</a>
        <a href="#">4</a>
        <a href="#">5</a>
        <a href="#">6</a>
        <a href="#">
          <span className="next"></span>
        </a>
      </div>
    </>
  )
}

export default Services
