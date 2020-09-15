import React from 'react'

const ProgramQuestions = () => {
  return (
    <>
      <div className="container-0 table-programs questions mt-20">
        <h3 className="result-title">
						<span className="back">
							<i className="icon-left"></i>
							<span className="back-text">Вернуться<br/>к программам</span>
						</span>
          Вопросы к программе «Производственный менеджмент»
        </h3>
        <table className="table">
          <thead>
          <tr>
            <th className="column__date">Дата/время</th>
            <th>Автор заявки</th>
            <th>Вопрос</th>
            <th></th>
          </tr>
          </thead>
          <tbody>
          <tr>
            <td>25.10.20 <br/> 19:33</td>
            <td className="name-block"><a href="#">Петракова Александра Анатольевна</a></td>
            <td className="q-block active"><p className="text">Скажите подалуйста, диплом по данной программе будет
              государственного образца?</p></td>
            <td>
              <div className="buttons">
                <button className="open-answer button-b">Ответить</button>
              </div>
            </td>
          </tr>
          <tr>
            <td>25.10.20 <br/> 19:33</td>
            <td><a href="#">Петракова Александра Анатольевна</a></td>
            <td className="q-block"><p className="text">Хотелось бы приобрести программу в рассрочку на 5-6 месяцев с
              предоплатой 30% в июне</p></td>
            <td className="support-block">
              <div className="supported">
                Ответ есть <i className="icon-correct"></i>
              </div>
            </td>
          </tr>
          </tbody>
        </table>
      </div>
    </>
  )
}

export default ProgramQuestions
