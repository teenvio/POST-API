using System;
using System.Collections.Generic;
using System.Text;
using System.Net;

namespace teenvio.com{
	public class API
	{
		private enum Method { GET, POST }

		private string urlBase="https://secure.teenvio.com/v4/public/api/post/";
		private string plan="";
		private string user="";
		private string pass="";
		private Method apiMethod=Method.POST;

		public API(string user,string plan, string pass){
			this.user = user;
			this.plan = plan;
			this.pass = pass;
		}

		public void useMethodPOST(){
			this.apiMethod = Method.POST;
		}

		public void useMethodGET(){
			this.apiMethod = Method.GET;
		}

		public string SaveContact(Dictionary<string, string> Params,int fromId=1, int groupId=0, int newsletterId=0)
        {
            Params.Add ("action", "contact_save");
			Params.Add ("plan", this.plan);
			Params.Add ("user", this.user);
			Params.Add ("pass", this.pass);
			Params.Add ("rid", fromId.ToString());
			Params.Add ("pid", newsletterId.ToString());
			if (groupId!=0){
				Params.Add ("gid", groupId.ToString());
			}


            return GetResponse(this.urlBase, Params, this.apiMethod);

        }

		public string DeleteContact(string email){
			Dictionary<string, string> Params = new Dictionary<string, string>();
			Params.Add ("action", "contact_delete");
			Params.Add ("plan", this.plan);
			Params.Add ("user", this.user);
			Params.Add ("pass", this.pass);
			Params.Add ("email", email);

			return GetResponse(this.urlBase, Params, this.apiMethod);

		}

		public string GroupContact(string email, int groupId){
			Dictionary<string, string> Params = new Dictionary<string, string>();
			Params.Add ("action", "contact_group");
			Params.Add ("plan", this.plan);
			Params.Add ("user", this.user);
			Params.Add ("pass", this.pass);
			Params.Add ("email", email);
			Params.Add ("gid", groupId.ToString());

			return GetResponse(this.urlBase, Params, this.apiMethod);
		}

		public string UnGroupContact(string email, int groupId){
			Dictionary<string, string> Params = new Dictionary<string, string>();
			Params.Add ("action", "contact_ungroup");
			Params.Add ("plan", this.plan);
			Params.Add ("user", this.user);
			Params.Add ("pass", this.pass);
			Params.Add ("email", email);
			Params.Add ("gid", groupId.ToString());

			return GetResponse(this.urlBase, Params, this.apiMethod);
		}

		public string DeactivateContact(string email, int fromId){
			Dictionary<string, string> Params = new Dictionary<string, string>();
			Params.Add ("action", "contact_deactivate");
			Params.Add ("plan", this.plan);
			Params.Add ("user", this.user);
			Params.Add ("pass", this.pass);
			Params.Add ("email", email);
			Params.Add ("rid", fromId.ToString());

			return GetResponse(this.urlBase, Params, this.apiMethod);
		}

		public string ActivateContact(string email, int fromId){
			Dictionary<string, string> Params = new Dictionary<string, string>();
			Params.Add ("action", "contact_activate");
			Params.Add ("plan", this.plan);
			Params.Add ("user", this.user);
			Params.Add ("pass", this.pass);
			Params.Add ("email", email);
			Params.Add ("rid", fromId.ToString());

			return GetResponse(this.urlBase, Params, this.apiMethod);
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
		private static string GetResponse_GET(string url, Dictionary<string, string> parameters)
		{
			try
			{
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
			}
			catch (System.Web.HttpException ex)
			{

				if (ex.ErrorCode == 404)
					throw new Exception("Not found remote service " + url);
				else throw new Exception("Error: "+ex.GetHtmlErrorMessage());
			}
			catch(System.Net.WebException ex){
				using (WebResponse response = ex.Response)
				{
					if (response != null) {
						HttpWebResponse httpResponse = (HttpWebResponse)response;
						Console.WriteLine ("Error code: {0}", httpResponse.StatusCode);
						using (System.IO.Stream data = response.GetResponseStream())
						using (var reader = new System.IO.StreamReader(data)) {
							string text = reader.ReadToEnd ();
							return text;
						}
					} else throw ex;
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
		private static string GetResponse_POST(string url, Dictionary<string, string> parameters)
		{
			try
			{
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
			catch (System.Web.HttpException ex)
			{
				if (ex.ErrorCode == 404)
					throw new Exception("Not found remote service " + url);
				else throw new Exception("Error: "+ex.GetHtmlErrorMessage());
			}
			catch(System.Net.WebException ex){
				using (WebResponse response = ex.Response)
				{
					if (response != null) {
						HttpWebResponse httpResponse = (HttpWebResponse)response;
						Console.WriteLine ("Error code: {0}", httpResponse.StatusCode);
						using (System.IO.Stream data = response.GetResponseStream())
							using (var reader = new System.IO.StreamReader(data)) {
							string text = reader.ReadToEnd ();
							return text;
						}
					} else throw ex;
				}
			}
		}
	}
}