import React from 'react';
import css from './search.scss';

class Search extends React.Component {
  render() {
    return (
      <div>
        <form className="filter-form">
          <div className="form-group row">
            <label htmlFor="paymentId" className="col-auto col-form-label">Id:</label>
            <div className="col-1 px-0">
              <input type="number" className="form-control" id="id" value="" name="filter[id]"/>
            </div>
            <label htmlFor="orderId" className="col-auto col-form-label">Название:</label>
            <div className="col-1 px-0">
              <input type="text" className="form-control" id="name" value="" name="filter[name]"/>
            </div>
            <label className="col-auto col-form-label" htmlFor="state">Тип:</label>
            <div className="col-1 px-0">

            </div>
          </div>

          <div className="form-group row">
            <div className="col-10">
              <button type="submit" className="btn btn-primary">
                <i className="fas fa-search"></i>
                &nbsp;Найти
              </button>
              <button type="reset" className="btn btn-light">Сбросить</button>
            </div>
          </div>
        </form>
        <div className="table-hr"></div>
      </div>
    );
  }
}

export default Search;
