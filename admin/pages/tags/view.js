import React, {useState, useEffect} from 'react';
import Breadcrumbs from '../../components/breadcrumbs/breacrumbs';
import PanelTitle from '../../components/panel/panel-title';
import Table from '../../components/table/table';
import Paginator from '../../components/paginator/paginator';
import axios from 'axios';

export default function TagView({match}) {
  const [item, setItem] = useState({
    id: match.params.id,
    name: '',
    sort: 0
  });

  const getBreadcrumbs = () => {
    return [
      {
        title: 'Главная',
        link: '/',
      },
      {
        title: 'Список тегов',
        link: '/tag',
      },
      {
        title: item.name,
        link: null,
      }
    ];
  }

  useEffect(() => {
    axios.get(`/api/admin/tag/${item.id}`)
      .then(({data}) => {
        setItem({
          id: data.id,
          name: data.name,
          sort: data.sort,
        });
      });
  }, []);


  return (
    <div className="page">
      <Breadcrumbs items={getBreadcrumbs()}/>

      <div className="portlet w-50">
        <PanelTitle
          title={'Просмотр местоположения'}
          icon={'fa fa-eye'}
          withButton={false}
        />

        <div className="body">
          <table className="table">
            <tbody>
            <tr>
              <td>ID</td>
              <td>{item.id}</td>
            </tr>
            <tr>
              <td>Название</td>
              <td>{item.name}</td>
            </tr>
            <tr>
              <td>Сортировка</td>
              <td>{item.sort}</td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  );
};
