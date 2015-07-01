/// ---------------------------------------------------------------------------------
/// <copyright>Ipdea Land, S.L. / Teenvio</copyright>
/// <author>Víctor J. Chamorro</author>
///
/// LGPL v3 - GNU LESSER GENERAL PUBLIC LICENSE
///
/// This program is free software: you can redistribute it and/or modify
/// it under the terms of the GNU LESSER General Public License as published by
/// the Free Software Foundation, either version 3 of the License.
/// 
/// This program is distributed in the hope that it will be useful,
/// but WITHOUT ANY WARRANTY; without even the implied warranty of
/// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
/// GNU General Public License for more details.
///
/// You should have received a copy of the GNU LESSER General Public License
/// along with this program.  If not, see <http://www.gnu.org/licenses/>.
/// ---------------------------------------------------------------------------------

namespace Teenvio{
	using System;
	using System.Web;
	using System.Collections.Generic;
	using System.Text;
	using System.Net;

	public class TeenvioAPI
	{
		public const string Version="1.0-20150616";

		private enum Method { GET, POST }
		public enum StatSection{
			ALL,
			SEND,
			SEND_OPENED,
			SEND_OPENED_ACTIVE,
			SEND_OPENED_UNSUBSCRIBED,
			SEND_UNOPENED,
			SEND_UNOPENED_DELIVERED,
			SEND_UNOPENED_BOUNCED,
			UNSEND,
			UNSEND_UNSUBSCRIBED,
			UNSEND_UNSUBSCRIBED_VOLUNTARY,
			UNSEND_UNSUBSCRIBED_AUTOMATIC,
			UNSEND_FAILED,
			UNSEND_FAILED_NOMENCLATURE,
			CLICKED
		}
		public enum OutputMode{
			PLAIN,
			JSON,
			XML,
			CSV
		}

		private string urlBase="https://master2.teenvio.com/v4/public/api/post/";
		//private string urlBase="https://secure.teenvio.com/v4/public/api/post/";
		//private string urlBase="http://127.0.0.1/v4/public/api/post/";
		private string plan="";
		private string user="";
		private string pass="";
		private Method apiMethod=Method.POST;

		public TeenvioAPI(string user,string plan, string pass){
			this.user = user;
			this.plan = plan;
			this.pass = pass;
			ServicePointManager.ServerCertificateValidationCallback = (a, b, c, d) => { return true; };
		}

		/// <summary>
		/// Gets current client version.
		/// </summary>
		/// <returns>Number of current client version</returns>
		public string getClientVersion(){
			return TeenvioAPI.Version;
		}

		/// <summary>
		/// Gets the server version.
		/// </summary>
		/// <returns>The server version.</returns>
		public string getServerVersion(){
			Dictionary<string, string> Params = new Dictionary<string, string>();
			Params.Add ("action", "get_version");
			Params.Add ("plan", this.plan);
			Params.Add ("user", this.user);
			Params.Add ("pass", this.pass);
			string bruto=GetResponse(this.urlBase, Params, this.apiMethod);
			if (bruto.Substring(0,2)=="OK"){
				return bruto.Substring(3);
			}
			throw new TeenvioException(bruto);
		}

		/// <summary>
		/// Check connection whit currents params
		/// </summary>
		public Boolean Ping(){
			Dictionary<string, string> Params = new Dictionary<string, string>();
			Params.Add ("action", "get_version");
			Params.Add ("plan", this.plan);
			Params.Add ("user", this.user);
			Params.Add ("pass", this.pass);
			string bruto=GetResponse(this.urlBase, Params, this.apiMethod);
			return (bruto.Substring (0, 2) == "OK");
		}

		/// <summary>
		/// Set HTTP Method to POST
		/// </summary>
		public void useMethodPOST(){
			this.apiMethod = Method.POST;
		}

		/// <summary>
		/// Set HTTP Method to GET
		/// </summary>
		public void useMethodGET(){
			this.apiMethod = Method.GET;
		}

		/// <summary>
		/// Save new or Update contact
		/// </summary>
		/// <returns>Contact Id</returns>
		public int SaveContact(Dictionary<string, string> Params,int fromId=1, int groupId=0, int newsletterId=0){
			Params.Add ("action", "contact_save");
			Params.Add ("plan", this.plan);
			Params.Add ("user", this.user);
			Params.Add ("pass", this.pass);
			Params.Add ("rid", fromId.ToString());
			Params.Add ("pid", newsletterId.ToString());
			if (groupId!=0){
				Params.Add ("gid", groupId.ToString());
			}
			string bruto= GetResponse(this.urlBase, Params, this.apiMethod);
			if (bruto.Substring(0,2)=="OK"){
				return int.Parse (bruto.Substring (3));
			}
			throw new TeenvioException(bruto);
		}

		/// <summary>
		/// Delete contact
		/// </summary>
		public void DeleteContact(string email){
			Dictionary<string, string> Params = new Dictionary<string, string>();
			Params.Add ("action", "contact_delete");
			Params.Add ("plan", this.plan);
			Params.Add ("user", this.user);
			Params.Add ("pass", this.pass);
			Params.Add ("email", email);

			string bruto= GetResponse(this.urlBase, Params, this.apiMethod);
			if (bruto.Substring (0, 2) != "OK") {
				throw new TeenvioException (bruto);
			}
		}

		/// <summary>
		/// Group contact
		/// </summary>
		public void GroupContact(string email, int groupId){
			Dictionary<string, string> Params = new Dictionary<string, string>();
			Params.Add ("action", "contact_group");
			Params.Add ("plan", this.plan);
			Params.Add ("user", this.user);
			Params.Add ("pass", this.pass);
			Params.Add ("email", email);
			Params.Add ("gid", groupId.ToString());

			string bruto= GetResponse(this.urlBase, Params, this.apiMethod);
			if (bruto.Substring (0, 2) != "OK") {
				throw new TeenvioException (bruto);
			}
		}

		/// <summary>
		/// Ungroup contact
		/// </summary>
		public void UnGroupContact(string email, int groupId){
			Dictionary<string, string> Params = new Dictionary<string, string>();
			Params.Add ("action", "contact_ungroup");
			Params.Add ("plan", this.plan);
			Params.Add ("user", this.user);
			Params.Add ("pass", this.pass);
			Params.Add ("email", email);
			Params.Add ("gid", groupId.ToString());

			string bruto= GetResponse(this.urlBase, Params, this.apiMethod);
			if (bruto.Substring (0, 2) != "OK") {
				throw new TeenvioException (bruto);
			}
		}

		/// <summary>
		/// Deactivate contact
		/// </summary>
		public void DeactivateContact(string email, int fromId){
			Dictionary<string, string> Params = new Dictionary<string, string>();
			Params.Add ("action", "contact_deactivate");
			Params.Add ("plan", this.plan);
			Params.Add ("user", this.user);
			Params.Add ("pass", this.pass);
			Params.Add ("email", email);
			Params.Add ("rid", fromId.ToString());

			string bruto= GetResponse(this.urlBase, Params, this.apiMethod);
			if (bruto.Substring (0, 2) != "OK") {
				throw new TeenvioException (bruto);
			}
		}

		/// <summary>
		/// Activate contact
		/// </summary>
		public void ActivateContact(string email, int fromId){
			Dictionary<string, string> Params = new Dictionary<string, string>();
			Params.Add ("action", "contact_activate");
			Params.Add ("plan", this.plan);
			Params.Add ("user", this.user);
			Params.Add ("pass", this.pass);
			Params.Add ("email", email);
			Params.Add ("rid", fromId.ToString());

			string bruto= GetResponse(this.urlBase, Params, this.apiMethod);
			if (bruto.Substring (0, 2) != "OK") {
				throw new TeenvioException (bruto);
			}
		}

		/// <summary>
		/// Get XML Stats Data
		/// </summary>
		public string GetStats(int id, OutputMode mode=OutputMode.XML){
			Dictionary<string, string> Params = new Dictionary<string, string>();
			Params.Add ("action", "get_stats");
			Params.Add ("plan", this.plan);
			Params.Add ("user", this.user);
			Params.Add ("pass", this.pass);
			Params.Add ("mode", mode.ToString().ToLower()); //XML or JSON
			Params.Add ("eid", id.ToString());

			string bruto= GetResponse(this.urlBase, Params, this.apiMethod);
			if (bruto.Substring (0, 2) == "KO") {
				throw new TeenvioException (bruto);
			}
			return GetResponse(this.urlBase, Params, this.apiMethod);
		}

		/// <summary>
		/// Get XML, JSON, PLAIN List conctact from section into Stats
		/// </summary>
		public string GetContactsStatSection(int id, StatSection section, OutputMode mode=OutputMode.XML){
			Dictionary<string, string> Params = new Dictionary<string, string>();
			Params.Add ("action", "get_contacts_stat_section");
			Params.Add ("plan", this.plan);
			Params.Add ("user", this.user);
			Params.Add ("pass", this.pass);
			Params.Add ("mode", mode.ToString().ToLower()); //CSV, XML or JSON
			Params.Add ("eid", id.ToString());
			Params.Add ("section", section.ToString().ToLower());

			string bruto= GetResponse(this.urlBase, Params, this.apiMethod);
			if (bruto.Substring (0, 2) == "KO") {
				throw new TeenvioException (bruto);
			}
			return bruto;
		}

		/// <summary>
		/// Get last ids Campaings/Stats
		/// </summary>
		public int[] GetCampaigns(int limit=25){
			Dictionary<string, string> Params = new Dictionary<string, string>();
			Params.Add ("action", "get_campaigns");
			Params.Add ("plan", this.plan);
			Params.Add ("user", this.user);
			Params.Add ("pass", this.pass);
			Params.Add ("mode", "plain"); // Plain, CSV, XML or JSON
			Params.Add ("limit", limit.ToString());

			string bruto= GetResponse(this.urlBase, Params, this.apiMethod);
			if (bruto.Substring (0, 2) == "KO") {
				throw new TeenvioException (bruto);
			}

			string[] array=bruto.Split (new string[] { "\n" }, StringSplitOptions.None);

			return Array.ConvertAll(array , int.Parse);

		}

		/// <summary>
		/// Realiza el envio de parametros a un servicio web utilizando el metodo GET o POST
		/// </summary>
		/// <param name="urlBase">url del servicio</param>
		/// <param name="parameters">pares clave-valor que se enviaran</param>
		/// <param name="method">GET | POST</param>
		/// <returns>devuelve una cadena con la respuesta del servidor, o excepción si no funcionó</returns>
		/// <author>Findemor http://findemor.porExpertos.es</author>
		/// <history>Creado 17/02/2012</history>
		private string GetResponse(string urlBase, Dictionary<string, string> parameters, Method method)
		{
			switch (method)
			{
				case Method.GET:
				return GetResponse_GET(urlBase, parameters);
				case Method.POST:
				return GetResponse_POST(urlBase, parameters);
				default:
				throw new NotImplementedException();
			}
		}

		/// <summary>
		/// Concatena los parámetros a una cadena de texto compatible con el API Rest
		/// </summary>
		/// <param name="parameters"></param>
		/// <returns>Parametros concatenados en formato URL, no establece el caracter "?" al principio
		/// pero sí los "&" separadores</returns>
		/// <author>Findemor http://findemor.porExpertos.es</author>
		/// <history>Creado 17/02/2012</history>
		private static string ConcatParams(Dictionary<string, string> parameters)
		{
			bool FirstParam = true;
			StringBuilder Parametros = null;

			if (parameters != null)
			{
				Parametros = new StringBuilder();
				foreach (KeyValuePair<string, string> param in parameters)
				{
					Parametros.Append(FirstParam ? "" : "&");
					Parametros.Append(param.Key + "=" + System.Web.HttpUtility.UrlEncode(param.Value));
					FirstParam = false;
				}
			}

			return Parametros == null ? string.Empty : Parametros.ToString();
		}


		/// <summary>
		/// Realiza la peticion utilizando el método GET y devuelve la respuesta del servidor
		/// </summary>
		/// <param name="url"></param>
		/// <returns></returns>
		/// <author>Findemor http://findemor.porExpertos.es</author>
		/// <history>Creado 17/02/2012</history>
		private static string GetResponse_GET(string url, Dictionary<string, string> parameters){
			try{
				//Concatenamos los parametros, OJO: antes del primero debe estar el caracter "?"
				string parametrosConcatenados = ConcatParams(parameters);
				string urlConParametros = url + "?" + parametrosConcatenados;

				System.Net.WebRequest wr = (System.Net.HttpWebRequest)System.Net.WebRequest.Create(urlConParametros);
				wr.Method = "GET";

				wr.ContentType = "application/x-www-form-urlencoded";

				System.IO.Stream newStream;
				// Obtiene la respuesta
				System.Net.WebResponse response = wr.GetResponse();
				// Stream con el contenido recibido del servidor
				newStream = response.GetResponseStream();
				System.IO.StreamReader reader = new System.IO.StreamReader(newStream);
				// Leemos el contenido
				string responseFromServer = reader.ReadToEnd();

				// Cerramos los streams
				reader.Close();
				newStream.Close();
				response.Close();
				return responseFromServer;
			}catch (System.Web.HttpException ex){
				if (ex.ErrorCode == 404)
					throw new Exception("Not found remote service " + url);
				else throw new Exception("Error: "+ex.GetHtmlErrorMessage());
			}catch(System.Net.WebException ex){
				using (WebResponse response = ex.Response){
					if (response != null) {
						HttpWebResponse httpResponse = (HttpWebResponse)response;
						if (httpResponse.StatusCode == HttpStatusCode.BadRequest) {
							using (System.IO.Stream data = response.GetResponseStream())
								using (var reader = new System.IO.StreamReader(data)) {
								string text = reader.ReadToEnd ();
								return text;
							}
						}
					}
					throw ex;
				}
			}
		}


		/// <summary>
		/// Realiza la petición utilizando el método POST y devuelve la respuesta del servidor
		/// </summary>
		/// <param name="url"></param>
		/// <returns></returns>
		/// <author>Findemor http://findemor.porExpertos.es</author>
		/// <history>Creado 17/02/2012</history>
		private static string GetResponse_POST(string url, Dictionary<string, string> parameters){
			try{
				//Concatenamos los parametros, OJO: NO se añade el caracter "?"
				string parametrosConcatenados = ConcatParams(parameters);

				System.Net.WebRequest wr = (System.Net.HttpWebRequest)System.Net.WebRequest.Create(url);
				wr.Method = "POST";

				wr.ContentType = "application/x-www-form-urlencoded";

				System.IO.Stream newStream;
				//Codificación del mensaje
				System.Text.ASCIIEncoding encoding = new System.Text.ASCIIEncoding();
				byte[] byte1 = encoding.GetBytes(parametrosConcatenados);
				wr.ContentLength = byte1.Length;
				//Envio de parametros
				newStream = wr.GetRequestStream();
				newStream.Write(byte1, 0, byte1.Length);

				// Obtiene la respuesta
				System.Net.WebResponse response = wr.GetResponse();
				// Stream con el contenido recibido del servidor
				newStream = response.GetResponseStream();
				System.IO.StreamReader reader = new System.IO.StreamReader(newStream);
				// Leemos el contenido
				string responseFromServer = reader.ReadToEnd();

				// Cerramos los streams
				reader.Close();
				newStream.Close();
				response.Close();
				return responseFromServer;
			}
			catch (System.Web.HttpException ex){
				if (ex.ErrorCode == 404)
					throw new Exception("Not found remote service " + url);
				else throw new Exception("Error: "+ex.GetHtmlErrorMessage());
			}catch(System.Net.WebException ex){
				using (WebResponse response = ex.Response){
					if (response != null) {
						HttpWebResponse httpResponse = (HttpWebResponse)response;
						if (httpResponse.StatusCode == HttpStatusCode.BadRequest) {
							using (System.IO.Stream data = response.GetResponseStream())
							using (var reader = new System.IO.StreamReader(data)) {
								string text = reader.ReadToEnd ();
								return text;
							}
						}
					}
					throw ex;
				}
			}
		}
	}
}