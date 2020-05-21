import React from 'react';
import Breadcrumbs from "../../components/breadcrumbs/breacrumbs";
import PanelTitle from "../../components/panel/panel-title";
import Table from "../../components/table/table";
import Paginator from "../../components/paginator/paginator";

class LocationView extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      name: 'dsf'
    };
  }

  componentDidMount() {
    const {
      match: {params}
    } = this.props;
    console.log(params)
    // axios.get(`/api/users/${params.userId}`)
    //   .then(({data: user}) => {
    //     console.log('user', user);
    //
    //     this.setState({user});
    //   });
  }

  render() {
    return (
      <div className="page">
        <Breadcrumbs/>

        <div className="portlet">
          <PanelTitle
            title={'Просмотр местоположения'}
            icon={'fa fa-eye'}
            withButton={false}
          />

          <div className="body">

            <table className="table table-striped mt-5">
              <tbody>
              <tr>
                <td>ID</td>
                <td>43243</td>
              </tr>
              <tr>
                <td>Название</td>
                <td>dfsdfsdf</td>
              </tr>
              <tr>
                <td>Тип</td>
                <td>fsdfdsf</td>
              </tr>
              <tr>
                <td>Сортировка</td>
                <td>4234</td>
              </tr>
              {/*{% if location.parentLocation is not null %}*/}
              <tr>
                <td>Родительское местороложение</td>
                <td>
                  <a href="{{ path('admin.location.view', {id: location.parentLocation.id}) }}">
                    dsfsdf
                  </a>
                </td>
              </tr>
              {/*{% endif %}*/}
              </tbody>
            </table>
          </div>
        </div>
      </div>
    )
  }
}

export default LocationView;
