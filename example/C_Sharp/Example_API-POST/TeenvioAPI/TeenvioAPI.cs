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

namespace Teenvio {
	using System.Collections.Generic;
	using System.Net;
	using System.Runtime.Serialization.Json;
	using System.Text;
	using System.Web;
	using System;

	public class TeenvioAPI {
		public const string Version = "2.0-dotnet-20180314";

		private enum Method { GET, POST }
		public enum StatSection {
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
		public enum OutputMode {
			PLAIN,
			JSON,
			XML,
			CSV
		}

		private string urlBase = "https://central1.teenvio.com/v4/public/api/post/";
		private string urlCall = "";
		private string plan = "";
		private string user = "";
		private string pass = "";
		private Method apiMethod = Method.POST;

		public TeenvioAPI (string user, string plan, string pass) {
			this.user = user;
			this.plan = plan;
			this.pass = pass;
			//ServicePointManager.ServerCertificateValidationCallback = (a, b, c, d) => { return true; };

			if (!this.Ping ()) {
				throw new TeenvioException ("Failed to connect: vefify the user credentials");
			}

			if (this.urlCall == "") {
				this.urlCall = this.getURLCall ();
			}

		}

		public string getURLCall () {
			Dictionary<string, string> Params = new Dictionary<string, string> ();
			Params.Add ("action", "get_url_call");
			Params.Add ("plan", this.plan);
			Params.Add ("user", this.user);
			Params.Add ("pass", this.pass);
			string bruto = GetResponse ( Params, this.apiMethod);
			if (bruto.Substring (0, 2) == "OK") {
				return bruto.Substring (4);
			}
			throw new TeenvioException (bruto);
		}

		/// <summary>
		/// Gets current client version.
		/// </summary>
		/// <returns>Number of current client version</returns>
		public string getClientVersion () {
			return TeenvioAPI.Version;
		}

		/// <summary>
		/// Gets the server version.
		/// </summary>
		/// <returns>The server version.</returns>
		public string getServerVersion () {
			Dictionary<string, string> Params = new Dictionary<string, string> ();
			Params.Add ("action", "get_version");
			Params.Add ("plan", this.plan);
			Params.Add ("user", this.user);
			Params.Add ("pass", this.pass);
			string bruto = GetResponse ( Params, this.apiMethod);
			if (bruto.Substring (0, 2) == "OK") {
				return bruto.Substring (4);
			}
			throw new TeenvioException (bruto);
		}

		/// <summary>
		/// Check connection whit currents params
		/// </summary>
		public Boolean Ping () {
			Dictionary<string, string> Params = new Dictionary<string, string> ();
			Params.Add ("action", "get_version");
			Params.Add ("plan", this.plan);
			Params.Add ("user", this.user);
			Params.Add ("pass", this.pass);
			string bruto = GetResponse ( Params, this.apiMethod);
			return (bruto.Substring (0, 2) == "OK");
		}

		/// <summary>
		/// Set HTTP Method to POST
		/// </summary>
		public void useMethodPOST () {
			this.apiMethod = Method.POST;
		}

		/// <summary>
		/// Set HTTP Method to GET
		/// </summary>
		public void useMethodGET () {
			this.apiMethod = Method.GET;
		}

		/// <summary>
		/// Save new or Update contact
		/// All fields in the documentation:
		/// https://github.com/teenvio/POST-API/tree/master/doc
		/// </summary>
		/// <returns>Contact Id</returns>
		public int SaveContact (Dictionary<string, string> Params, int fromId = 0, int groupId = 0, int newsletterId = 0) {
			Params.Add ("action", "contact_save");
			Params.Add ("plan", this.plan);
			Params.Add ("user", this.user);
			Params.Add ("pass", this.pass);
			if (fromId!=0){
				Params.Add ("rid", fromId.ToString ());
			}
			if (groupId!= 0) {
				Params.Add ("gid", groupId.ToString ());
			}
			if (newsletterId!=0){
				Params.Add ("pid", newsletterId.ToString ());
			}

			string bruto = GetResponse ( Params, this.apiMethod);
			if (bruto.Substring (0, 2) == "OK") {
				return int.Parse (bruto.Substring (4));
			}
			throw new TeenvioException (bruto);
		}

		/// <summary>
		/// Delete contact
		/// </summary>
		public void DeleteContact (string email) {
			Dictionary<string, string> Params = new Dictionary<string, string> ();
			Params.Add ("action", "contact_delete");
			Params.Add ("plan", this.plan);
			Params.Add ("user", this.user);
			Params.Add ("pass", this.pass);
			Params.Add ("email", email);

			string bruto = GetResponse ( Params, this.apiMethod);
			if (bruto.Substring (0, 2) != "OK") {
				throw new TeenvioException (bruto);
			}
		}

		/// <summary>
		/// Save new or Update group
		/// </summary>
		/// <returns>Group Id</returns>
		public int SaveGroup (String name, String description, int groupId) {
			Dictionary<string, string> Params = new Dictionary<string, string> ();
			Params.Add ("action", "group_save");
			Params.Add ("plan", this.plan);
			Params.Add ("user", this.user);
			Params.Add ("pass", this.pass);
			Params.Add ("name", name.ToString ());
			Params.Add ("description", description.ToString ());

			if (groupId != 0) {
				Params.Add ("gid", groupId.ToString ());
			}
			string bruto = GetResponse ( Params, this.apiMethod);
			if (bruto.Substring (0, 2) == "OK") {
				return int.Parse (bruto.Substring (4));
			}
			throw new TeenvioException (bruto);
		}

		/// <summary>
		/// Delete group
		/// </summary>
		public void DeleteGroup (int groupId) {
			Dictionary<string, string> Params = new Dictionary<string, string> ();
			Params.Add ("action", "group_delete");
			Params.Add ("plan", this.plan);
			Params.Add ("user", this.user);
			Params.Add ("pass", this.pass);
			Params.Add ("gid", groupId.ToString ());

			string bruto = GetResponse ( Params, this.apiMethod);
			if (bruto.Substring (0, 2) != "OK") {
				throw new TeenvioException (bruto);
			}
		}

		/// <summary>
		/// Group contact
		/// </summary>
		public void GroupContact (string email, int groupId) {
			Dictionary<string, string> Params = new Dictionary<string, string> ();
			Params.Add ("action", "contact_group");
			Params.Add ("plan", this.plan);
			Params.Add ("user", this.user);
			Params.Add ("pass", this.pass);
			Params.Add ("email", email);
			Params.Add ("gid", groupId.ToString ());

			string bruto = GetResponse ( Params, this.apiMethod);
			if (bruto.Substring (0, 2) != "OK") {
				throw new TeenvioException (bruto);
			}
		}

		/// <summary>
		/// Ungroup contact
		/// </summary>
		public void UnGroupContact (string email, int groupId) {
			Dictionary<string, string> Params = new Dictionary<string, string> ();
			Params.Add ("action", "contact_ungroup");
			Params.Add ("plan", this.plan);
			Params.Add ("user", this.user);
			Params.Add ("pass", this.pass);
			Params.Add ("email", email);
			Params.Add ("gid", groupId.ToString ());

			string bruto = GetResponse ( Params, this.apiMethod);
			if (bruto.Substring (0, 2) != "OK") {
				throw new TeenvioException (bruto);
			}
		}

		/// <summary>
		/// Deactivate contact
		/// </summary>
		public void DeactivateContact (string email, int fromId) {
			Dictionary<string, string> Params = new Dictionary<string, string> ();
			Params.Add ("action", "contact_deactivate");
			Params.Add ("plan", this.plan);
			Params.Add ("user", this.user);
			Params.Add ("pass", this.pass);
			Params.Add ("email", email);
			Params.Add ("rid", fromId.ToString ());

			string bruto = GetResponse ( Params, this.apiMethod);
			if (bruto.Substring (0, 2) != "OK") {
				throw new TeenvioException (bruto);
			}
		}

		/// <summary>
		/// Activate contact
		/// </summary>
		public void ActivateContact (string email, int fromId) {
			Dictionary<string, string> Params = new Dictionary<string, string> ();
			Params.Add ("action", "contact_activate");
			Params.Add ("plan", this.plan);
			Params.Add ("user", this.user);
			Params.Add ("pass", this.pass);
			Params.Add ("email", email);
			Params.Add ("rid", fromId.ToString ());

			string bruto = GetResponse ( Params, this.apiMethod);
			if (bruto.Substring (0, 2) != "OK") {
				throw new TeenvioException (bruto);
			}
		}

		/// <summary>
		/// Get XML/Json Contact data
		/// </summary>
		/// <returns>XML/Json String</returns>
		public string GetContactData (string email, OutputMode mode = OutputMode.XML) {
			Dictionary<string, string> Params = new Dictionary<string, string> ();
			Params.Add ("action", "contact_data");
			Params.Add ("plan", this.plan);
			Params.Add ("user", this.user);
			Params.Add ("pass", this.pass);
			Params.Add ("mode", mode.ToString ().ToLower ()); //XML or JSON
			Params.Add ("email", email.ToString ());

			string bruto = GetResponse ( Params, this.apiMethod);
			if (bruto.Substring (0, 2) == "KO") {
				throw new TeenvioException (bruto);
			}
			return bruto;
		}

		/// <summary>
		/// Return fields names and internal names from contacts in XML/Json
		/// </summary>
		/// <returns>XML/Json String</returns>
		public string GetContactFields (OutputMode mode = OutputMode.XML) {
			Dictionary<string, string> Params = new Dictionary<string, string> ();
			Params.Add ("action", "contact_fields");
			Params.Add ("plan", this.plan);
			Params.Add ("user", this.user);
			Params.Add ("pass", this.pass);
			Params.Add ("mode", mode.ToString ().ToLower ()); //XML or JSON

			string bruto = GetResponse ( Params, this.apiMethod);
			if (bruto.Substring (0, 2) == "KO") {
				throw new TeenvioException (bruto);
			}
			return bruto;
		}

		/// <summary>
		/// Return group data
		/// </summary>
		/// <returns>XML/Json String</returns>
		public string GetGroupData (int groupId, OutputMode mode = OutputMode.XML) {
			Dictionary<string, string> Params = new Dictionary<string, string> ();
			Params.Add ("action", "group_data");
			Params.Add ("plan", this.plan);
			Params.Add ("user", this.user);
			Params.Add ("pass", this.pass);
			Params.Add ("gid", groupId.ToString ());
			Params.Add ("mode", mode.ToString ().ToLower ()); //XML or JSON

			string bruto = GetResponse ( Params, this.apiMethod);
			if (bruto.Substring (0, 2) == "KO") {
				throw new TeenvioException (bruto);
			}
			return bruto;
		}

		/// <summary>
		/// Return group contacts list
		/// </summary>
		/// <returns>XML/Json String</returns>
		public string GetGroupContacts (int groupId, OutputMode mode = OutputMode.XML) {
			Dictionary<string, string> Params = new Dictionary<string, string> ();
			Params.Add ("action", "group_list_contacts");
			Params.Add ("plan", this.plan);
			Params.Add ("user", this.user);
			Params.Add ("pass", this.pass);
			Params.Add ("gid", groupId.ToString ());
			Params.Add ("mode", mode.ToString ().ToLower ()); //XML or JSON

			string bruto = GetResponse ( Params, this.apiMethod);
			if (bruto.Substring (0, 2) == "KO") {
				throw new TeenvioException (bruto);
			}
			return bruto;
		}

		/// <summary>
		/// Return group list
		/// </summary>
		/// <returns>XML/Json String</returns>
		public string GetGroupsList (OutputMode mode = OutputMode.XML) {
			Dictionary<string, string> Params = new Dictionary<string, string> ();
			Params.Add ("action", "group_list");
			Params.Add ("plan", this.plan);
			Params.Add ("user", this.user);
			Params.Add ("pass", this.pass);
			Params.Add ("mode", mode.ToString ().ToLower ()); //XML or JSON

			string bruto = GetResponse ( Params, this.apiMethod);
			if (bruto.Substring (0, 2) == "KO") {
				throw new TeenvioException (bruto);
			}
			return bruto;
		}

		/// <summary>
		/// Get XML/Json Stats Data
		/// </summary>
		public string GetStats (int id, OutputMode mode = OutputMode.XML) {
			Dictionary<string, string> Params = new Dictionary<string, string> ();
			Params.Add ("action", "get_stats");
			Params.Add ("plan", this.plan);
			Params.Add ("user", this.user);
			Params.Add ("pass", this.pass);
			Params.Add ("mode", mode.ToString ().ToLower ()); //XML or JSON
			Params.Add ("eid", id.ToString ());

			string bruto = GetResponse ( Params, this.apiMethod);
			if (bruto.Substring (0, 2) == "KO") {
				throw new TeenvioException (bruto);
			}
			return bruto;
		}

		/// <summary>
		/// Return group data
		/// </summary>
		/// <returns>XML/Json String</returns>
		public string GetAccountData (OutputMode mode = OutputMode.XML) {
			Dictionary<string, string> Params = new Dictionary<string, string> ();
			Params.Add ("action", "get_account_data");
			Params.Add ("plan", this.plan);
			Params.Add ("user", this.user);
			Params.Add ("pass", this.pass);
			Params.Add ("mode", mode.ToString ().ToLower ()); //XML or JSON

			string bruto = GetResponse ( Params, this.apiMethod);
			if (bruto.Substring (0, 2) == "KO") {
				throw new TeenvioException (bruto);
			}
			return bruto;
		}

		/// <summary>
		/// Return from/sender data
		/// </summary>
		/// <returns>XML/Json String</returns>
		public string GetFrom (int fromId, OutputMode mode = OutputMode.XML) {
			Dictionary<string, string> Params = new Dictionary<string, string> ();
			Params.Add ("action", "get_account_data");
			Params.Add ("plan", this.plan);
			Params.Add ("user", this.user);
			Params.Add ("pass", this.pass);
			Params.Add ("mode", mode.ToString ().ToLower ()); //XML or JSON
			Params.Add ("rid", fromId.ToString ());

			string bruto = GetResponse ( Params, this.apiMethod);
			if (bruto.Substring (0, 2) == "KO") {
				throw new TeenvioException (bruto);
			}
			return bruto;
		}

		/// <summary>
		/// Get XML, JSON, PLAIN List conctact from section into Stats
		/// </summary>
		public string GetContactsStatSection (int id, StatSection section, OutputMode mode = OutputMode.XML) {
			Dictionary<string, string> Params = new Dictionary<string, string> ();
			Params.Add ("action", "get_contacts_stat_section");
			Params.Add ("plan", this.plan);
			Params.Add ("user", this.user);
			Params.Add ("pass", this.pass);
			Params.Add ("mode", mode.ToString ().ToLower ()); //CSV, XML or JSON
			Params.Add ("eid", id.ToString ());
			Params.Add ("section", section.ToString ().ToLower ());

			string bruto = GetResponse ( Params, this.apiMethod);
			if (bruto.Substring (0, 2) == "KO") {
				throw new TeenvioException (bruto);
			}
			return bruto;
		}

		/// <summary>
		/// Get last ids Campaings/Stats
		/// </summary>
		public int[] GetCampaigns (int limit = 25) {
			Dictionary<string, string> Params = new Dictionary<string, string> ();
			Params.Add ("action", "get_campaigns");
			Params.Add ("plan", this.plan);
			Params.Add ("user", this.user);
			Params.Add ("pass", this.pass);
			Params.Add ("mode", "plain");
			Params.Add ("limit", limit.ToString ());

			string bruto = GetResponse ( Params, this.apiMethod);
			if (bruto.Substring (0, 2) == "KO") {
				throw new TeenvioException (bruto);
			}

			string[] array = bruto.Split (new string[] { "\n" }, StringSplitOptions.None);

			return Array.ConvertAll (array, int.Parse);
		}

		/// <summary>
		/// Semd Email/Campaign
		/// </summary>
		/// <returns>New Campaing/Stat Id</returns>
		public int SendEmail (int groupId, int newsletterId, int fromId, string name, string subject, string analytics = "", bool header = true, bool headerShare = false, bool socialFoot = false, Dictionary<string, string> extraVars = null) {
			Dictionary<string, string> Params = new Dictionary<string, string> ();
			Params.Add ("action", "send_campaign");
			Params.Add ("plan", this.plan);
			Params.Add ("user", this.user);
			Params.Add ("pass", this.pass);
			Params.Add ("gid", groupId.ToString ());
			Params.Add ("pid", newsletterId.ToString ());
			Params.Add ("rid", fromId.ToString ());
			Params.Add ("name", name.ToString ());
			Params.Add ("subject", subject.ToString ());
			Params.Add ("analytics", subject.ToString ());
			Params.Add ("cab", (header) ? "1" : "0");
			Params.Add ("share", (headerShare) ? "1" : "0");
			Params.Add ("social_foot", (socialFoot) ? "1" : "0");

			if (extraVars != null) {
				Params.Add ("vars", TeenvioAPI.JSONDictionaryEncode(extraVars));
			}

			string bruto = GetResponse ( Params, this.apiMethod);
			if (bruto.Substring (0, 2) == "OK") {
				return int.Parse (bruto.Substring (4));
			}
			throw new TeenvioException (bruto);
		}

		/// <summary>
		/// Send Email/Campaign to single contact
		/// </summary>
		/// <returns>New Campaing/Stat Id</returns>
		public int SendEmailUnique (int contactId, int newsletterId, int fromId, string name, string subject, string analytics = "", bool header = true, bool headerShare = false, bool socialFoot = false, Dictionary<string, string> extraVars = null) {
			Dictionary<string, string> Params = new Dictionary<string, string> ();
			Params.Add ("action", "send_campaign");
			Params.Add ("plan", this.plan);
			Params.Add ("user", this.user);
			Params.Add ("pass", this.pass);
			Params.Add ("contact_id", contactId.ToString ());
			Params.Add ("pid", newsletterId.ToString ());
			Params.Add ("rid", fromId.ToString ());
			Params.Add ("name", name.ToString ());
			Params.Add ("subject", subject.ToString ());
			Params.Add ("analytics", subject.ToString ());
			Params.Add ("cab", (header) ? "1" : "0");
			Params.Add ("share", (headerShare) ? "1" : "0");
			Params.Add ("social_foot", (socialFoot) ? "1" : "0");

			if (extraVars != null) {
				Params.Add ("vars", TeenvioAPI.JSONDictionaryEncode(extraVars));
			}

			string bruto = GetResponse ( Params, this.apiMethod);
			if (bruto.Substring (0, 2) == "OK") {
				return int.Parse (bruto.Substring (4));
			}
			throw new TeenvioException (bruto);
		}

		/// <sumary>
		/// Save Newsletter
		/// </sumary>
		/// <returns>Id saved newsletter</returns>
		public int SaveNewsletter(string name,string html,string plain="",int newsletterId=0){
			Dictionary<string, string> Params = new Dictionary<string, string> ();
			Params.Add ("action", "newsletter_save");
			Params.Add ("plan", this.plan);
			Params.Add ("user", this.user);
			Params.Add ("pass", this.pass);

			Params.Add ("name", name);
			Params.Add ("html", html);
			Params.Add ("plain", plain);
			Params.Add ("id_newsletter", newsletterId.ToString());
			
			string bruto = GetResponse ( Params, this.apiMethod);
			if (bruto.Substring (0, 2) == "OK") {
				return int.Parse (bruto.Substring (4));
			}
			throw new TeenvioException (bruto);
		}

		/// <sumary>
		/// Delete Newsletter
		/// </sumary>
		public void DeleteNewsletter(int newsletterId){
			Dictionary<string, string> Params = new Dictionary<string, string> ();
			Params.Add ("action", "newsletter_delete");
			Params.Add ("plan", this.plan);
			Params.Add ("user", this.user);
			Params.Add ("pass", this.pass);
			Params.Add ("id_newsletter", newsletterId.ToString ());

			string bruto = GetResponse ( Params, this.apiMethod);
			if (bruto.Substring (0, 2) != "OK") {
				throw new TeenvioException (bruto);
			}
		}

		/// <sumary>
		/// Get Newsletter data
		/// </sumary>
		public string GetNewsletterData(int newsletterId,OutputMode mode = OutputMode.XML) {
			Dictionary<string, string> Params = new Dictionary<string, string> ();
			Params.Add ("action", "newsletter_data");
			Params.Add ("plan", this.plan);
			Params.Add ("user", this.user);
			Params.Add ("pass", this.pass);
			Params.Add ("mode", mode.ToString ().ToLower ()); //XML or JSON
			Params.Add ("id_newsletter",newsletterId.ToString());

			string bruto = GetResponse ( Params, this.apiMethod);
			if (bruto.Substring (0, 2) == "KO") {
				throw new TeenvioException (bruto);
			}
			return bruto;
		}

		/// <sumary>
		/// Upload a file
		/// </sumary>
		/// <returns>Public URL file</returns>
		public string uploadFile(string name,byte[] raw,string path="/"){
			Dictionary<string, string> Params = new Dictionary<string, string> ();
			Params.Add ("action", "newsletter_add_file");
			Params.Add ("plan", this.plan);
			Params.Add ("user", this.user);
			Params.Add ("pass", this.pass);
			Params.Add ("name", name);
			Params.Add ("path", path);
			Params.Add ("encoding", "base64");
			Params.Add ("content", Convert.ToBase64String(raw));

			string bruto = GetResponse ( Params, TeenvioAPI.Method.POST);
			if (bruto.Substring (0, 2) == "KO") {
				throw new TeenvioException (bruto);
			}
			return bruto.Substring(4);
		}

		/// <sumary>
		/// Get from/senders list
		/// </sumary>
		public string GetSenderList(OutputMode mode = OutputMode.XML){
			Dictionary<string, string> Params = new Dictionary<string, string> ();
			Params.Add ("action", "sender_list");
			Params.Add ("plan", this.plan);
			Params.Add ("user", this.user);
			Params.Add ("pass", this.pass);
			Params.Add ("mode", mode.ToString ().ToLower ()); //XML or JSON
			
			string bruto = GetResponse ( Params, this.apiMethod);
			if (bruto.Substring (0, 2) == "KO") {
				throw new TeenvioException (bruto);
			}
			return bruto;
		}

		/// <summary>
		/// Realiza el envio de parametros a un servicio web utilizando el metodo GET o POST
		/// </summary>
		/// <param name="urlBase">url del servicio</param>
		/// <param name="parameters">pares clave-valor que se enviaran</param>
		/// <param name="method">GET | POST</param>
		/// <returns>devuelve una cadena con la respuesta del servidor, o excepción si no funcionó</returns>
		private string GetResponse (Dictionary<string, string> parameters, Method method) {

			string url = this.urlCall;

			if (url == "") {
				url = this.urlBase;
			}

			parameters.Add ("client", Version);

			switch (method) {
				case Method.GET:
					return GetResponse_GET (url, parameters);
				case Method.POST:
					return GetResponse_POST (url, parameters);
				default:
					throw new NotImplementedException ();
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
		private static string ConcatParams (Dictionary<string, string> parameters) {
			bool FirstParam = true;
			StringBuilder Parametros = null;

			if (parameters != null) {
				Parametros = new StringBuilder ();
				foreach (KeyValuePair<string, string> param in parameters) {
					Parametros.Append (FirstParam ? "" : "&");
					Parametros.Append (param.Key + "=" + System.Web.HttpUtility.UrlEncode (param.Value));
					FirstParam = false;
				}
			}

			return Parametros == null ? string.Empty : Parametros.ToString ();
		}

		/// <summary>
		/// Realiza la peticion utilizando el método GET y devuelve la respuesta del servidor
		/// </summary>
		/// <param name="url"></param>
		/// <returns></returns>
		/// <author>Findemor http://findemor.porExpertos.es</author>
		/// <history>Creado 17/02/2012</history>
		private static string GetResponse_GET (string url, Dictionary<string, string> parameters) {
			try {
				//Concatenamos los parametros, OJO: antes del primero debe estar el caracter "?"
				string parametrosConcatenados = ConcatParams (parameters);
				string urlConParametros = url + "?" + parametrosConcatenados;

				System.Net.WebRequest wr = (System.Net.HttpWebRequest) System.Net.WebRequest.Create (urlConParametros);
				wr.Method = "GET";

				wr.ContentType = "application/x-www-form-urlencoded";

				System.IO.Stream newStream;
				// Obtiene la respuesta
				System.Net.WebResponse response = wr.GetResponse ();
				// Stream con el contenido recibido del servidor
				newStream = response.GetResponseStream ();
				System.IO.StreamReader reader = new System.IO.StreamReader (newStream);
				// Leemos el contenido
				string responseFromServer = reader.ReadToEnd ();

				// Cerramos los streams
				reader.Close ();
				newStream.Close ();
				response.Close ();
				return responseFromServer;

			} catch (System.Net.WebException ex) {
				using (WebResponse response = ex.Response) {
					if (response != null) {
						HttpWebResponse httpResponse = (HttpWebResponse) response;
						if (httpResponse.StatusCode == HttpStatusCode.BadRequest) {
							using (System.IO.Stream data = response.GetResponseStream ())
							using (var reader = new System.IO.StreamReader (data)) {
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
		private static string GetResponse_POST (string url, Dictionary<string, string> parameters) {
			try {
				//Concatenamos los parametros, OJO: NO se añade el caracter "?"
				string parametrosConcatenados = ConcatParams (parameters);

				System.Net.WebRequest wr = (System.Net.HttpWebRequest) System.Net.WebRequest.Create (url);
				wr.Method = "POST";

				wr.ContentType = "application/x-www-form-urlencoded";

				System.IO.Stream newStream;
				//Codificación del mensaje
				System.Text.ASCIIEncoding encoding = new System.Text.ASCIIEncoding ();
				byte[] byte1 = encoding.GetBytes (parametrosConcatenados);
				wr.ContentLength = byte1.Length;
				//Envio de parametros
				newStream = wr.GetRequestStream ();
				newStream.Write (byte1, 0, byte1.Length);

				// Obtiene la respuesta
				System.Net.WebResponse response = wr.GetResponse ();
				// Stream con el contenido recibido del servidor
				newStream = response.GetResponseStream ();
				System.IO.StreamReader reader = new System.IO.StreamReader (newStream);
				// Leemos el contenido
				string responseFromServer = reader.ReadToEnd ();

				// Cerramos los streams
				reader.Close ();
				newStream.Close ();
				response.Close ();
				return responseFromServer;

			} catch (System.Net.WebException ex) {
				using (WebResponse response = ex.Response) {
					if (response != null) {
						HttpWebResponse httpResponse = (HttpWebResponse) response;
						if (httpResponse.StatusCode == HttpStatusCode.BadRequest) {
							using (System.IO.Stream data = response.GetResponseStream ())
							using (var reader = new System.IO.StreamReader (data)) {
								string text = reader.ReadToEnd ();
								return text;
							}
						}
					}
					throw ex;
				}
			}
		}

		public static string JSONStringEncode (string value) {
			System.Text.StringBuilder sb = new System.Text.StringBuilder ();
			int start = 0;
			for (int i = 0; i < value.Length; i++){
				char c = value[i];
				
				if (
					(c < 32) ||
					(c > 33 && c < 48 && c != 46) ||
					(c > 58 && c < 65) ||
					(c > 90 && c < 97 && c != 95) ||
					(c > 123)
				){
					sb.Append (value, start, i - start);
					switch (value[i]) {
						case '\b':
							sb.Append ("\\b");
							break;
						case '\f':
							sb.Append ("\\f");
							break;
						case '\n':
							sb.Append ("\\n");
							break;
						case '\r':
							sb.Append ("\\r");
							break;
						case '\t':
							sb.Append ("\\t");
							break;
						case '\"':
							sb.Append ("\\\"");
							break;
						case '\\':
							sb.Append ("\\\\");
							break;
						case '/':
							sb.Append ("\\/");
							break;
						default:
							sb.Append ("\\u");
							sb.Append (((int) value[i]).ToString ("x04"));
							break;
					}
					start = i + 1;
				}
			}
			sb.Append (value, start, value.Length - start);
			return sb.ToString ();
		}

		public static string JSONDictionaryEncode(Dictionary<string, string> data){
			String json="{";
            foreach(KeyValuePair<string, string> entry in data ){
                if (json.Length>1) json+=",";
                json+="\""+TeenvioAPI.JSONStringEncode(entry.Key.ToString())+"\":\""+
                    TeenvioAPI.JSONStringEncode(entry.Value.ToString())+"\"";
            }
            json+="}";
			return json;
		}
	}
}