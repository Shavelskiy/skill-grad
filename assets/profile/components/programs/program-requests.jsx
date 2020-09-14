import React from 'react'


const ProgramRequests = () => {
  return (
    <>
      <div className="container-0 table-programs applications mt-20">
        <h3 className="result-title">
          <span className="back"><i className="icon-left"></i><span
            className="back-text">Вернуться<br/>к программам</span></span>
          Заявки к программе <br className="show-mobile"/> «Производственный менеджмент»
        </h3>
        <table className="table">
          <thead>
          <tr>
            <th className="column__date">Дата/время</th>
            <th className="column__author">Автор заявки</th>
            <th className="column__contact">Контакты</th>
            <th>Комментарий</th>
            <th></th>
          </tr>
          </thead>
          <tbody>
          <tr>
            <td>25.10.20 <br/> 19:33</td>
            <td className="name-block"><a href="#">Петракова Александра Анатольевна</a></td>
            <td className="contact"><a className="d-flex" href="#">petrakova@mail.ru</a>+7 (900) 644-66-98</td>
            <td className="reviews-text"><p className="text">Хотелось бы приобрести программу в рассрочку на 5-6
              месяцев с предоплатой 30% в июне</p></td>
            <td>
              <div className="buttons">
                <button className="button-b">Подтвердить</button>
                <button className="button-r open-reject">Отклонить</button>
              </div>
            </td>
          </tr>
          <tr>
            <td>25.10.20 <br/> 19:33</td>
            <td className="name-block"><a href="#">Петракова Александра Анатольевна</a></td>
            <td className="contact"><a className="d-flex" href="#">petrakova@mail.ru</a>+7 (900) 644-66-98</td>
            <td className="reviews-text"><p className="text">Хотелось бы приобрести программу в рассрочку на 5-6
              месяцев с предоплатой 30% в июне</p></td>
            <td>
              <div className="buttons">
                <button className="button-b">Подтвердить</button>
                <button className="button-r open-reject">Отклонить</button>
              </div>
            </td>
          </tr>
          <tr>
            <td>25.10.20 <br/> 19:33</td>
            <td className="name-block"><a href="#">ПетраковаАлександра Анатольевна</a></td>
            <td className="contact"><a className="d-flex" href="#">petrakova@mail.ru</a>+7 (900) 644-66-98</td>
            <td className="reviews-text"><p className="text">Хотелось бы приобрести программу в рассрочку на 5-6
              месяцев с предоплатой 30% в июне</p></td>
            <td className="support-block">
              <div className="rejected">
                Заявка отклонена <i className="icon-cancel"></i>
              </div>
            </td>
          </tr>
          <tr>
            <td>25.10.20 <br/> 19:33</td>
            <td className="name-block"><a href="#">ПетраковаАлександра Анатольевна</a></td>
            <td className="contact"><a className="d-flex" href="#">petrakova@mail.ru</a>+7 (900) 644-66-98</td>
            <td className="reviews-text"><p className="text">Хотелось бы приобрести программу в рассрочку на 5-6
              месяцев с предоплатой 30% в июне</p></td>
            <td className="support-block">
              <div className="supported">
                Заявка подтверждена <i className="icon-correct"></i>
              </div>
            </td>
          </tr>
          </tbody>
        </table>
      </div>

    </>
)
}

export default ProgramRequests
